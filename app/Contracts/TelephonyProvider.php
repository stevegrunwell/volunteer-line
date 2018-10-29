<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface TelephonyProvider
{
    /**
     * Ring multiple numbers at the same time and connect the inbound call to the first number
     * to pick up.
     *
     * @param \Illuminate\Support\Collection $numbers The PhoneNumber instances to dial.
     */
    public function groupDial(Collection $numbers);
}
