<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param array $override
     * @return string[]
     */
    public function userData(array $override=[]){
         return \array_merge([
            'username'              => 'EdwardLopez',
            'first_name'            => 'Edward',
            'last_name'             => 'Lopez',
            'email'                 => 'edward@edtlsoft.com',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
        ], $override);
    }

    /**
     * @param $userData
     * @return TestResponse
     */
    public function postRouteRegister($userData): TestResponse
    {
        return $this->post(route('register'), $userData);
    }

    /** @test */
    public function users_can_register()
    {
        $this->postRouteRegister($this->userData());

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

    /** @test */
    public function a_user_register_requires_a_username()
    {
        $this->postRouteRegister(
            $this->userData(['username' => ''])
        )->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function the_username_must_be_a_string()
    {
        $this->postRouteRegister(
            $this->userData(['username' => 12345])
        )->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function the_username_may_not_be_greater_than_50_characters()
    {
        $this->postRouteRegister(
            $this->userData(['username' => Str::random(51)])
        )->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function the_username_must_be_unique()
    {
        $user = factory(User::class)->create(['username' => 'EdwardLopez']);

        $this->postRouteRegister(
            $this->userData(['username' => $user->username])
        )->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function the_username_may_only_contain_letters_and_numbers()
    {
        $this->postRouteRegister(
            $this->userData(['username' => 'Edward Lopez'])
        )->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function the_username_must_be_at_least_5_characters()
    {
        $this->postRouteRegister(
            $this->userData(['username' => 'Ana'])
        )->assertSessionHasErrors(['username']);
    }

    /** @test */
    public function a_user_register_requires_a_first_name()
    {
        $this->postRouteRegister(
            $this->userData(['first_name' => ''])
        )->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function the_first_name_must_be_a_string()
    {
        $this->postRouteRegister(
            $this->userData(['first_name' => 12345])
        )->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_50_characters()
    {
        $this->postRouteRegister(
            $this->userData(['first_name' => Str::random(51)])
        )->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function the_first_name_may_only_contain_letters()
    {
        $this->postRouteRegister(
            $this->userData(['first_name' => 'Edward Lopez123'])
        )->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function the_first_name_must_be_at_least_5_characters()
    {
        $this->postRouteRegister(
            $this->userData(['first_name' => 'Ana'])
        )->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function a_user_register_requires_a_last_name()
    {
        $this->postRouteRegister(
            $this->userData(['last_name' => ''])
        )->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function the_last_name_must_be_a_string()
    {
        $this->postRouteRegister(
            $this->userData(['last_name' => 12345])
        )->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_50_characters()
    {
        $this->postRouteRegister(
            $this->userData(['last_name' => Str::random(51)])
        )->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function the_last_name_may_only_contain_letters()
    {
        $this->postRouteRegister(
            $this->userData(['last_name' => 'Lopez123456'])
        )->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function the_last_name_must_be_at_least_5_characters()
    {
        $this->postRouteRegister(
            $this->userData(['last_name' => 'Ana'])
        )->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    public function a_user_register_requires_an_email()
    {
        $this->postRouteRegister(
            $this->userData(['email' => ''])
        )->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function the_email_must_be_a_valid_email_address()
    {
        $this->postRouteRegister(
            $this->userData(['email' => 'invalid@'])
        )->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function the_email_may_not_be_greater_than_150_characters()
    {
        $this->postRouteRegister(
            $this->userData(['email' => Str::random(151)])
        )->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);

        $this->postRouteRegister(
            $this->userData(['email' => $user->email])
        )->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function a_user_register_requires_an_password()
    {
        $this->postRouteRegister(
            $this->userData(['password' => ''])
        )->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function the_password_must_be_a_string()
    {
        $this->postRouteRegister(
            $this->userData(['password' => 12345])
        )->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function the_password_must_be_at_least_8_characters()
    {
        $this->postRouteRegister(
            $this->userData(['password' => '1234567'])
        )->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->postRouteRegister(
            $this->userData([
                'password' => '12345678',
                'password_confirmation' => ''
            ])
        )->assertSessionHasErrors(['password']);
    }
}
