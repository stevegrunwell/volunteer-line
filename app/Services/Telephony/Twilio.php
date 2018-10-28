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
    public $twiml;

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
        $this->twiml->dial($numbers->toArray());

        return $this->twiml;
    }
}
