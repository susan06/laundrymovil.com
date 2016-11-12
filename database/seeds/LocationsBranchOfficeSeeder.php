<?php

use Illuminate\Database\Seeder;

class LocationsBranchOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branch_office_locations')->insert([
            'branch_office_id' => 1,
            'label' => 'address 1',
            'lat' => '9.760786787003136',
            'lng' => '-63.15146337933351',
            'address' => 'Cocuizas, carrera 5, casa #43',
        ]);

        DB::table('branch_office_locations')->insert([
            'branch_office_id' => 2,
            'label' => 'address 1',
            'lat' => '9.760786787003136',
            'lng' => '-63.15146337933351',
            'address' => 'Cocuizas, carrera 5, casa #50',
        ]);
    }
}
