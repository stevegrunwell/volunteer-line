<?php

namespace Tests\Unit;

use App\Group;
use App\PhoneNumber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipToPhoneNumbers()
    {
        $group = factory(Group::class)->create();
        $group->phoneNumbers()->saveMany(factory(PhoneNumber::class, 2)->make());

        $this->assertCount(2, $group->phoneNumbers);
    }

    public function testRelationshipToUsers()
    {
        $group = factory(Group::class)->create();
        $group->users()->saveMany(factory(User::class, 2)->make());

        $this->assertCount(2, $group->users);
    }

    public function testGetAvailableNumbers()
    {
        $group = factory(Group::class)->create();
        $users = $group->users()->saveMany(factory(User::class, 2)->make());
        $numbers = [];
        $users->each(function ($user) use (&$numbers) {
            $numbers[] = $user->phoneNumbers()->save(factory(PhoneNumber::class)->make())->number;
        });

        sort($numbers);

        $this->assertEquals(
            $numbers,
            $group->getAvailableNumbers()->sortBy('number')->pluck('number')->toArray()
        );
    }

    public function testGetKeyAttribute()
    {
        $group = factory(Group::class)->make();

        $this->assertSame($group->getAttributes()['key'], $group->key);
    }

    public function testGetKeyAttributeGeneratesKey()
    {
        $group = factory(Group::class)->make();
        $group->setRawAttributes([
            'key' => null,
        ]);

        $this->assertNotEmpty($group->key, 'A key should have been generated.');
    }

    public function testScopeManageable()
    {
        $user = factory(User::class)->create();
        $groups = $user->groups()->saveMany(factory(Group::class, 3)->make());
        $user->groups()->updateExistingPivot($groups[1]->id, [
            'can_manage' => true,
        ]);

        $this->assertSame(1, $user->groups()->manageable()->count());
    }

    public function testScopeManageableOnlyAppliesWhenUserPivotDataIsPresent()
    {
        factory(Group::class, 3)->create();

        $this->assertSame(3, Group::manageable()->count());
    }

    public function testGenerateKey()
    {
        $key = Group::generateKey();

        $this->assertSame(32, strlen($key), 'Keys should be 32 characters long');
    }
}
