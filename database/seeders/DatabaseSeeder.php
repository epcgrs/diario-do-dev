<?php

namespace Database\Seeders;

use App\Core\Models\Content;
use App\Core\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Emmanuel P. Pires',
            'email' => 'emmanuelf988@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'type' => 'master'
        ]);

        User::factory(10)->create();
        Content::factory(10)->create();

    }
}
