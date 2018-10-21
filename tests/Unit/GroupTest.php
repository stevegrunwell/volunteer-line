<?php

namespace Tests\Unit;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function testAssociationToGroups()
    {
        $group = factory(Group::class)->create();
        $group->users()->saveMany(factory(User::class, 2)->make());

        $this->assertCount(2, $group->users);
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
}
