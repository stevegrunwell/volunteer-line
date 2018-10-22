<?php

namespace Tests\Unit\Services\Telephony;

use App\Services\Telephony\Twilio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Twilio\Twiml;

class TwilioTest extends TestCase
{
    public function testForwardTo()
    {
        $twilio = new Twilio;
        $twilio->twiml = Mockery::spy(Twiml::class);

        $twilio->forwardTo('+15558675309');

        $twilio->twiml->shouldHaveReceived('dial')
            ->once()
            ->with('+15558675309');
    }
}
