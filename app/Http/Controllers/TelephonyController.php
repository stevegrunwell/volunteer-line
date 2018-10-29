<?php

namespace App\Http\Controllers;

use App\Group;
use App\PhoneNumber;
use App\Services\Telephony\Twilio;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TelephonyController extends Controller
{
    public function twilio(Request $request, Group $group, Twilio $twilio)
    {
        $twilio->setCallerIdNumber($request->get('to'));

        return response($twilio->groupDial($group->getAvailableNumbers()))
            ->header('Content-Type', 'application/xml');
    }
}
