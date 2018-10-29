<?php

namespace Tests\Feature;

use App\Group;
use App\PhoneNumber;
use App\Http\Controllers\GroupController;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Groups extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanSeeGroupCreationForm()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->get(route('group.create'));

        $response->assertViewIs('group.create');
    }

    public function testUsersCanCreateGroups()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make();

        $response = $this->actingAs($user)
            ->post(route('group.store'), array_merge($group->toArray(), [
                'phone_numbers' => '+15558675309',
            ]));

        $response->assertRedirect('home');
        $response->assertSessionHas('success', trans('group.create.success', ['name' => $group->name]));

        $this->assertSame($user->id, Group::latest()->first()->created_by);
        $this->assertCount(1, $user->groups, 'The user should have automatically been assigned to the group.');
        $this->assertCount(1, $user->groups[0]->phoneNumbers);
    }

    public function testValidatesRequiredFieldsUponGroupCreation()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->make([
            'name' => '',
        ]);

        $response = $this->actingAs($user)
            ->post(route('group.store'), $group->toArray());

        $response->assertSessionHasErrors([
            'name' => trans('validation.required', ['attribute' => 'name']),
        ]);
    }

    public function testUsersCanEditGroup()
    {
        $user = factory(User::class)->create();
        $group = $user->groups()->save(factory(Group::class)->make(), [
            'can_manage' => true,
        ]);
        $this->assertCount(0, $group->phoneNumbers);

        $response = $this->actingAs($user)
            ->put(route('group.update', ['group' => $group]), array_merge($group->toArray(), [
                'name' => 'New Name',
                'phone_numbers' => '+15558675309',
            ]));

        $response->assertRedirect('home');
        $response->assertSessionHas('success', trans('group.edit.success', ['name' => 'New Name']));

        $group->refresh();

        $this->assertSame('New Name', $group->name);
        $this->assertCount(1, $group->phoneNumbers);
    }

    public function testValidatesRequiredFieldsUponGroupEdit()
    {
        $user = factory(User::class)->create();
        $group = $user->groups()->save(factory(Group::class)->make(), [
            'can_manage' => true,
        ]);

        $response = $this->actingAs($user)
            ->put(route('group.update', ['group' => $group]), array_merge($group->toArray(), [
                'name' => '',
            ]));

        $response->assertSessionHasErrors([
            'name' => trans('validation.required', ['attribute' => 'name']),
        ]);
    }

    public function testPhoneNumbersAreNotDuplicatedUponUpdate()
    {
        $user = factory(User::class)->create();
        $group = $user->groups()->save(factory(Group::class)->make(), [
            'can_manage' => true,
        ]);
        $number = $group->phoneNumbers()->save(factory(PhoneNumber::class)->make());

        $response = $this->actingAs($user)
            ->put(route('group.update', ['group' => $group]), array_merge($group->toArray(), [
                'phone_numbers' => $number->number . PHP_EOL . '+15558675309',
            ]));

        $group->refresh();

        $this->assertCount(2, $group->phoneNumbers);
    }

    public function testPhoneNumbersCanBeRemoved()
    {
        $user = factory(User::class)->create();
        $group = $user->groups()->save(factory(Group::class)->make(), [
            'can_manage' => true,
        ]);
        $number = $group->phoneNumbers()->save(factory(PhoneNumber::class)->create());

        $response = $this->actingAs($user)
            ->put(route('group.update', ['group' => $group]), array_merge($group->toArray(), [
                'phone_numbers' => '+15558675309',
            ]));

        $group->refresh();

        $this->assertCount(1, $group->phoneNumbers);
        $this->assertSame('+15558675309', $group->phoneNumbers->first()->number);
    }

    public function testUsersCannotEditGroupWithoutAdministrativePrivileges()
    {
        $user = factory(User::class)->create();
        $group = $user->groups()->save(factory(Group::class)->make());

        $this->actingAs($user)
            ->put(route('group.update', ['group' => $group]), $group->toArray())
            ->assertForbidden();
    }

    public function testParsePhoneNumbersFromTextarea()
    {
        $instance = new GroupController;
        $method = new \ReflectionMethod($instance, 'parsePhoneNumbersFromTextarea');
        $method->setAccessible(true);

        $textarea = <<<EOT
+18008675309

15558675309
EOT;

        $this->assertEquals([
            '+18008675309',
            '15558675309',
        ], $method->invoke($instance, $textarea));
    }
}
