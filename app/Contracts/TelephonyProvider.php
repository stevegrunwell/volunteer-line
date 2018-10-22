<?php

namespace App\Contracts;

interface TelephonyProvider
{
    /**
     * Forward a call to the given number.
     *
     * @param string $number The phone number to forward the call to.
     */
    public function forwardTo(string $number);
}
