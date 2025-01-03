<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'peserta']);

        $user1 = User::create([
            'name'      => 'admin',
            'email'     => 'admin@mail.com',
            'email_verified_at'     => Carbon::now(),
            'password'  => Hash::make('admin123'),
            'remember_token' => Str::random(40)
        ]);

        $user2 = User::create([
            'name'      => 'alex',
            'email'     => 'alex@mail.com',
            'email_verified_at'     => Carbon::now(),
            'password'  => Hash::make('admin123'),
            'remember_token' => Str::random(40)
        ]);

        $user3 = User::create([
            'name'      => 'smith',
            'email'     => 'smith@mail.com',
            'email_verified_at'     => Carbon::now(),
            'password'  => Hash::make('admin123'),
            'remember_token' => Str::random(40)
        ]);

        $user1->assignRole('admin');
        $user2->assignRole('peserta');
        $user3->assignRole('peserta');
    }
}
