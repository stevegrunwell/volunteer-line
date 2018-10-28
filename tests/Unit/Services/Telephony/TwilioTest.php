<?php

namespace Tests\Unit\Services\Telephony;

use App\PhoneNumber;
use App\Services\Telephony\Twilio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Twilio\Twiml;

class TwilioTest extends TestCase
{
    public function testGroupDial()
    {
        $twilio = new Twilio;
        $twilio->twiml = Mockery::spy(Twiml::class);
        $numbers = factory(PhoneNumber::class, 3)->make();

        $twilio->groupDial($numbers);

        $twilio->twiml->shouldHaveReceived('dial')
            ->once()
            ->with($numbers->toArray());
    }
}
