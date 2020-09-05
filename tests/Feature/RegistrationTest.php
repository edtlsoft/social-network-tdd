<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_register()
    {
        $this->withoutExceptionHandling();

        $userData = [
            'username'              => 'EdwardLopez',
            'first_name'            => 'Edward',
            'last_name'             => 'Lopez',
            'email'                 => 'edward@edtlsoft.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->post(route('register'), $userData);

        $this->assertDatabaseHas('users', [
            'username'   => 'EdwardLopez',
            'first_name' => 'Edward',
            'last_name'  => 'Lopez',
            'email'      => 'edward@edtlsoft.com',
        ]);

        $this->assertTrue(
            Hash::check('12345678', User::first()->password)
        );
    }
}
