<?php

namespace App\Services\Telephony;

use App\Contracts\TelephonyProvider;
use Illuminate\Database\Eloquent\Collection;
use Twilio\Twiml;

class Twilio implements TelephonyProvider
{
    /**
     * @var \Twilio\Twiml $twiml
     */
    private $twiml;

    /**
     * Create a new Twilio response.
     */
    public function __construct()
    {
        $this->twiml = new Twiml;
    }

    /**
     * Ring multiple numbers at the same time and connect the inbound call to the first number
     * to pick up.
     *
     * @param Collection $numbers The PhoneNumber instances to dial.
     */
    public function groupDial(Collection $numbers)
    {
        $dial = $this->twiml->dial();

        $numbers->take(10)->each(function ($number) use ($dial) {
            $dial->client($number->number);
        });

        return $this->twiml;
    }
}
