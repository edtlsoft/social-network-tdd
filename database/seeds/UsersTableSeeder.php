<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'username'   => 'EdwardLopez',
            'first_name' => 'Edward',
            'last_name'  => 'Lopez',
            'email'      => 'edward@edtlsoft.com',
            'password'   => \bcrypt('123')
        ]);

        factory(User::class)->create([
            'username'   => 'NewUser',
            'first_name' => 'New',
            'last_name'  => 'User',
            'email'      => 'newuser@edtlsoft.com',
            'password'   => \bcrypt('123')
        ]);
    }
}
