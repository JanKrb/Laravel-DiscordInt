<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->count() <= 0) {
            DB::table('users')->insert([
                'discord_id' => 0,
                'name' => 'Admin Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'birth_date' => now(),
            ]);
        }
    }
}
