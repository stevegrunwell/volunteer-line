<?php

namespace Tests\Unit;

use App\Group;
use App\PhoneNumber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneNumberTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipToGroups()
    {
        $number = factory(PhoneNumber::class)->create();
        $number->groups()->saveMany(factory(Group::class, 2)->make());

        $this->assertCount(2, $number->groups);
    }

    public function testRelationshipToUsers()
    {
        $number = factory(PhoneNumber::class)->create();
        $number->users()->saveMany(factory(User::class, 2)->make());

        $this->assertCount(2, $number->users);
    }
}
