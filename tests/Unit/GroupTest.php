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
}
