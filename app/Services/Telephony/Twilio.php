<?php

namespace App\Services\Telephony;

use App\Contracts\TelephonyProvider;
use Illuminate\Support\Collection;
use Twilio\Twiml;

class Twilio extends AbstractTelephonyProvider
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
     * @param \Illuminate\Support\Collection $numbers The PhoneNumber instances to dial.
     */
    public function groupDial(Collection $numbers)
    {
        $dial = $this->twiml->dial(array_filter([
            'callerId' => $this->callerIdNumber,
        ]));

        $numbers->take(10)->each(function ($number) use ($dial) {
            $dial->number($number->number);
        });

        return $this->twiml;
    }
}
