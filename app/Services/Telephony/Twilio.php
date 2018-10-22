<?php

namespace App\Services\Telephony;

use App\Contracts\TelephonyProvider;
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
     * Forward a call to the given number.
     *
     * @param string $number The phone number to forward the call to.
     */
    public function forwardTo(string $number)
    {
        $this->twiml->dial($number);

        return $this->twiml;
    }
}
