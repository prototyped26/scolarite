<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'role_id' => 1,
            'nom' => Str::random(10),
            'prenom' => Str::random(10),
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
