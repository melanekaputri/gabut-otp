<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use App\User;

class VerifyOTPTest extends TestCase
{
    use DatabaseMigrations;

    // When an user can submit OTP and get verified
    public function user_submit_otp()
    {
        
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $OTP = auth()->user()->cacheTheOTP();
        $this->post('/verifyOTP',[auth()->user()->OTPKey()=>$OTP])->assertStatus(201);

        $this->assertDatabaseHas('users',['isVerified'=>1]);
    }
}
