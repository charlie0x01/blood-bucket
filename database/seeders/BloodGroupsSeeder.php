<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodGroupsSeeder extends Seeder
{

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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        array_walk($this-> blood_groups, function ($blood_group) {
            BloodGroup::create($blood_group);
        });
    }
}
