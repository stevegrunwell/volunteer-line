<?php

namespace Tests\Unit\Services\Telephony;

use App\PhoneNumber;
use App\Services\Telephony\Twilio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\ArrayToXml\ArrayToXml;
use Tests\TestCase;
use Twilio\Twiml;

class TwilioTest extends TestCase
{
    public function testGroupDial()
    {
        $twilio = new Twilio;
        $numbers = factory(PhoneNumber::class, 3)->make();

        $this->assertXmlEqualsArray([
            'Dial' => [
                'Client' => $numbers->pluck('number')->toArray(),
            ],
        ], $twilio->groupDial($numbers));
    }

    public function testGroupDialLimitsTo10Numbers()
    {
        $twilio = new Twilio;
        $numbers = factory(PhoneNumber::class, 12)->make();

        $this->assertXmlEqualsArray([
            'Dial' => [
                'Client' => $numbers->take(10)->pluck('number')->toArray(),
            ],
        ], $twilio->groupDial($numbers));
    }

    /**
     * Assert that an XML string matches the given array representation.
     *
     * @param array $array    The array, which will be created via ArrayToXml.
     * @param string $xml     The XML string.
     * @param string $message An optional error message.
     */
    protected function assertXmlEqualsArray(array $array, string $xml, string $message = '')
    {
        $this->assertXmlStringEqualsXmlString(
            ArrayToXml::convert($array, [
                'rootElementName' => 'Response',
            ]),
            $xml,
            $message
        );
    }
}
