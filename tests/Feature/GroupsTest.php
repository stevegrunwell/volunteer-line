<?php

namespace Tests\Feature;

use App\Group;
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
            ->post(route('group.store'), $group->toArray());

        $response->assertRedirect('home');
        $response->assertSessionHas('success', trans('group.create.success', ['name' => $group->name]));

        $this->assertSame($user->id, Group::latest()->first()->created_by);
        $this->assertCount(1, $user->groups, 'The user should have automatically been assigned to the group.');
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

        $response = $this->actingAs($user)
            ->put(route('group.update', ['group' => $group]), array_merge($group->toArray(), [
                'name' => 'New Name',
            ]));

        $response->assertRedirect('home');
        $response->assertSessionHas('success', trans('group.edit.success', ['name' => 'New Name']));

        $group->refresh();

        $this->assertSame('New Name', $group->name);
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
}
