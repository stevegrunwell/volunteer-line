<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TelephonyProvider
{
    /**
     * Ring multiple numbers at the same time and connect the inbound call to the first number
     * to pick up.
     *
     * @param \Illuminate\Database\Eloquent\Collection $numbers The PhoneNumber instances to dial.
     */
    public function groupDial(Collection $numbers);
}
