<?php

namespace Tests\Feature;

use App\Group;
use App\PhoneNumber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TelephonyTest extends TestCase
{
    use RefreshDatabase;

    public function testGroupDialTwilio()
    {
        $group = factory(Group::class)->create();
        $phoneNumber = $group->phoneNumbers()->save(factory(PhoneNumber::class)->make());
        $users = $group->users()->saveMany(factory(User::class, 2)->make());
        $users->each(function ($user) {
            $user->phoneNumbers()->save(factory(PhoneNumber::class)->make());
        });

        $response = $this->post(route('groupDial.twilio', ['groupKey' => $group->key]), [
            'to' => $phoneNumber->number,
        ]);

        $response->assertHeader('Content-Type', 'application/xml');

        foreach ($group->getAvailableNumbers() as $number) {
            $response->assertSee('<Number>' . $number->number . '</Number>');
        }
    }
}
