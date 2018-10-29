<?php

namespace App\Services\Telephony;

use App\Contracts\TelephonyProvider;

abstract class AbstractTelephonyProvider implements TelephonyProvider
{
    /**
     * @var string The caller ID number to use when routing calls.
     */
    protected $callerIdNumber;

    /**
     * Set the caller ID number.
     *
     * @param string $number The E.164 caller ID number.
     *
     * @todo Validate the callback number before setting.
     */
    public function setCallerIdNumber(string $number)
    {
        $this->callerIdNumber = $number;
    }
}
