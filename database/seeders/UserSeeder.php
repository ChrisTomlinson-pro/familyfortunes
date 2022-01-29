<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'uuid'      => Str::uuid()->toString(),
            'email'     => 'samgaitens@msn.com',
            'password'  => Hash::make('password')
        ];
        $user = User::create($data);

        event(new Registered($user));
    }
}
