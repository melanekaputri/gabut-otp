<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    
    // Function user cant access home until verifired
    public function before_verified()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->get('/home')->assertRedirect('/');

    }

    // Function user can access home if verfired
    public function after_verified()
    {
        $user = factory(User::class)->create(['isVerified'=>1]);
        $this->actingAs($user);
        $this->get('/home')->assertStatus(200);
    }
}
