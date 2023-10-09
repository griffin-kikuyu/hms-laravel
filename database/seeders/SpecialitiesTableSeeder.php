<?php

namespace Database\Seeders;

use App\Models\Speciality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Speciality::create(['name' => 'General Practitioner']);
        Speciality::create(['name' => 'Dentist']);
        Speciality::create(['name' => 'Orthopedics']);
        Speciality::create(['name' => 'Dermatology']);
        Speciality::create(['name' => 'Emergency Medicine']);
       
    }
}
