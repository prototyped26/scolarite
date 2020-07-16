<?php

use Illuminate\Database\Seeder;

class SeederRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'id' => 1,
            'code' => "ADM",
            'libelle' => "Administrateur",
        ]);
        DB::table('role')->insert([
            'id' => 2,
            'code' => "CAS",
            'libelle' => "Caissière",
        ]);
        DB::table('role')->insert([
            'id' => 3,
            'code' => "INT",
            'libelle' => "Intendant",
        ]);
    }
}
