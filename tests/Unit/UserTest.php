<?php

namespace Tests\Unit;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testAssociationToGroups()
    {
        $user = factory(User::class)->create();
        $user->groups()->saveMany(factory(Group::class, 2)->make());

        $this->assertCount(2, $user->groups);
    }

    public function testGetDisplayNameAttribute()
    {
        $user = factory(User::class)->make([
            'first_name' => 'Ringo',
            'last_name' => 'Starr',
        ]);

        $this->assertSame('Ringo S.', $user->display_name);
    }
}
