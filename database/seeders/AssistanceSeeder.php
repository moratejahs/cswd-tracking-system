<?php

namespace Database\Seeders;

use App\Models\Assistance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assistance::create([
            'user_id' => 1,
            'first_name' => 'Juan',
            'middle_name' => 'Dela',
            'last_name' => 'Cruz',
            'birth_date' => now(),
            'address' => 'Dawis Tandag City',
            'contact_no' => '09706122212',
            'status' => 'Senior Citezin',
            'occupation' => 'Software Programmer',
            'assistance' => 'Animal Bite',
            'quantity' => 14,
            'person_of_responsible' => 'Head Person'
        ]);
    }
}
