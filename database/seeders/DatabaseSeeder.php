<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'Breno',
            'email' => 'breno@email',
            'email_verified_at' => now(),
            'password' => Hash::make('aaaa'),
            'remember_token' => 'fsdfasdfasdfdsfasdhdfhj',
        ]);
    }
}
