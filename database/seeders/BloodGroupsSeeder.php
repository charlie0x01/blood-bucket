<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    private $blood_groups = [
        ['name' => "A+"],
        ['name' => "A-"],
        ['name' => "B+"],
        ['name' => "B-"],
        ['name' => "AB+"],
        ['name' => "AB-"],
        ['name' => "O+"],
        ['name' => "O-"],
    ];

    public function run()
    {
        //
        array_walk($this-> blood_groups, function ($blood_group) {
            BloodGroup::create($blood_group);
        });
    }
}
