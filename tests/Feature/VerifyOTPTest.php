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
        $this->withExceptionHandling();
        $OTP = rand(100000, 999999);
        Cache::put(['OTP'=>$OTP],now()->addSeconds(20));
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->post('/verifyOTP',['OTP'=>$OTP])->assertStatus(201);

        $this->assertDatabaseHas('users',['isVerified'=>1]);
    }
}
