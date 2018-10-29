<?php

namespace Tests\Unit\Services\Telephony;

use App\Services\Telephony\AbstractTelephonyProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbstractTelephonyProviderTest extends TestCase
{
    public function testSetCallerIdNumber()
    {
        $mock = $this->getMockForAbstractClass(AbstractTelephonyProvider::class);
        $prop = new \ReflectionProperty(AbstractTelephonyProvider::class, 'callerIdNumber');
        $prop->setAccessible(true);

        $mock->setCallerIdNumber('+15558675309');

        $this->assertSame('+15558675309', $prop->getValue($mock));
    }

    public function testSetCallerIdNumberValidatesE164Format()
    {
        $this->markTestIncomplete('E.164 format validation has not yet been implemented.');
    }
}
