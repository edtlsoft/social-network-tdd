<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Status::class, 5)->create();

        $userEdward = \App\User::where('username', 'EdwardLopez')->first();

        factory(Status::class, 5)->create([
            'user_id'   => $userEdward->id,
        ]);
    }
}
