<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
                'mobile' => '09330945684',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123456'),
                'balance' => 50000,
            ]
        ]);
    }
}
