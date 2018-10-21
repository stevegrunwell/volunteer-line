<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testGetDisplayNameAttribute()
    {
        $user = factory(User::class)->make([
            'first_name' => 'Ringo',
            'last_name' => 'Starr',
        ]);

        $this->assertSame('Ringo S.', $user->display_name);
    }
}
