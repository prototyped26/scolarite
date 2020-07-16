<?php

use Illuminate\Database\Seeder;

class SeederAnnee extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('annee')->insert([
            'id' => 1,
            'code' => "2019-2020",
            'libelle' => "2019-2020",
            'date_debut' => "01-09-2019",
            'dete_fin' => "30-07-2020",
            'is_active' => true
        ]);
    }
}
