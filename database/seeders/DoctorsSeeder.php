<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        [
         'name' => 'Dr. Youssef Karim',
         'specialty' => 'Neurology',
         'city' => 'Marrakech',
         'yearsofexperience' => 15,
         'consultation_price' => '400',
         'available_days' => 'Monday to Friday'
        ],
          [
        'name' => 'Dr. Youssef Karim',
        'specialty' => 'Neurology',
        'city' => 'Marrakech',
        'yearsofexperience' => 15,
        'consultation_price' => '400',
        'available_days' => 'Monday to Friday'
    ],
    [
        'name' => 'Dr. Ahmed Benali',
        'specialty' => 'Cardiology',
        'city' => 'Casablanca',
        'yearsofexperience' => 12,
        'consultation_price' => '350',
        'available_days' => 'Monday, Wednesday'
    ],
    [
        'name' => 'Dr. Sara El Amrani',
        'specialty' => 'Dermatology',
        'city' => 'Rabat',
        'yearsofexperience' => 8,
        'consultation_price' => '250',
        'available_days' => 'Tuesday, Thursday'
    ],
    [
        'name' => 'Dr. Khalid Naciri',
        'specialty' => 'Orthopedics',
        'city' => 'Tangier',
        'yearsofexperience' => 10,
        'consultation_price' => '300',
        'available_days' => 'Monday, Thursday'
    ],
    [
        'name' => 'Dr. Fatima Zahra',
        'specialty' => 'Pediatrics',
        'city' => 'Fes',
        'yearsofexperience' => 7,
        'consultation_price' => '200',
        'available_days' => 'Wednesday, Friday'
    ],
    [
        'name' => 'Dr. Omar Idrissi',
        'specialty' => 'General Medicine',
        'city' => 'Agadir',
        'yearsofexperience' => 9,
        'consultation_price' => '220',
        'available_days' => 'Monday to Thursday'
    ],
    [
        'name' => 'Dr. Nadia Bennani',
        'specialty' => 'Gynecology',
        'city' => 'Casablanca',
        'yearsofexperience' => 13,
        'consultation_price' => '400',
        'available_days' => 'Tuesday, Friday'
    ],
    [
        'name' => 'Dr. Karim Alaoui',
        'specialty' => 'ENT',
        'city' => 'Rabat',
        'yearsofexperience' => 11,
        'consultation_price' => '280',
        'available_days' => 'Monday, Wednesday, Friday'
    ],
    [
        'name' => 'Dr. Salma Chafik',
        'specialty' => 'Ophthalmology',
        'city' => 'Meknes',
        'yearsofexperience' => 6,
        'consultation_price' => '260',
        'available_days' => 'Tuesday, Thursday'
    ]
    ];
      DB::table('doctors')->insert($data);
    }
}
