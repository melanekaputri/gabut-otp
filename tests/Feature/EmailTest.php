<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

class EmailTest extends TestCase
{
    use DatabaseMigrations;
    
    // An OTP send when user Login
    public function otp_email_user_login()
    {
        Mail::fake();

        $this->withExceptionHandling();
        $user = factory(User::class)->create();
        $res = $this->post('/login',['email'=>$user->email,'password'=>'secret']);

        Mail::assertSent(OTPMail::class);

        // $res->assertRedirect('/');
    }

    // OTP is not sent if credentials if not correct
    public function otp_not_sent_if_credentials_correct()
    {
        Mail::fake();

        // $this->withExceptionHandling();
        $user = factory(User::class)->create();
        $res = $this->post('/login',['email'=>$user->email,'password'=>'absssss']);

        Mail::assertNotSent(OTPMail::class);
    }

    //Test verified optional
    public function otp_stred_for_user()
    {
        $user = factory(User::class)->create();
        $res = $this->post('/login',['email'=>$user->email,'password'=>'secret']);
        $this->assertNotNull($user->OTP());
    }

}
