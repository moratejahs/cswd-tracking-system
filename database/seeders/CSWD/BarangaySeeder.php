<?php

namespace Database\Seeders\CSWD;

use App\Models\Barangay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = [
            ['name' => 'Awasian', 'latitude' => '9.071651312307543', 'longitude' => '126.162487818678'],
            ['name' => 'Bagong Lungsod (Poblacion)', 'latitude' => '9.07840811322997', 'longitude' => '126.1992890639329'],
            ['name' => 'Bioto', 'latitude' => '9.066121085386317', 'longitude' => '126.1789407724455'],
            ['name' => 'Bongtod Poblacion (East West)', 'latitude' => '9.084141321839013', 'longitude' => '126.19323166278106'],
            ['name' => 'Buenavista', 'latitude' => '9.121600152238353', 'longitude' => '126.15983180381019'],
            ['name' => 'Dagocdoc (Poblacion)', 'latitude' => '9.078319', 'longitude' => '126.194536'],
            ['name' => 'Mabua', 'latitude' => '9.071682', 'longitude' => '126.205704'],
            ['name' => 'Mabuhay', 'latitude' => '9.091768', 'longitude' => '126.132823'],
            ['name' => 'Maitum', 'latitude' => '9.067148', 'longitude' => '126.122245'],
            ['name' => 'Maticdum', 'latitude' => '9.036726', 'longitude' => '126.151949'],
            ['name' => 'Pandanon', 'latitude' => '9.056668', 'longitude' => '126.146299'],
            ['name' => 'Pangi', 'latitude' => '9.108202', 'longitude' => '126.135623'],
            ['name' => 'Quezon', 'latitude' => '9.059599', 'longitude' => '126.157458'],
            ['name' => 'Rosario', 'latitude' => '9.049894', 'longitude' => '126.200565'],
            ['name' => 'Salvacion', 'latitude' => '9.114638', 'longitude' => '126.147701'],
            ['name' => 'San Agustin Norte', 'latitude' => '9.095957', 'longitude' => '126.149307'],
            ['name' => 'San Agustin Sur', 'latitude' => '9.077198', 'longitude' => '126.186401'],
            ['name' => 'San Antonio', 'latitude' => '9.152063', 'longitude' => '126.162420'],
            ['name' => 'San Isidro', 'latitude' => '9.044549', 'longitude' => '126.167748'],
            ['name' => 'San Jose', 'latitude' => '9.046759', 'longitude' => '126.184373'],
            ['name' => 'Telaje', 'latitude' => '9.062234', 'longitude' => '126.192604'],
        ];

        foreach ($barangays as $barangay) {
            Barangay::create([
                'outlet_name' => $barangay['name'],
                'outlet_address' => "{$barangay['name']} Tandag, Surigao del Sur",
                'latitude' => $barangay['latitude'],
                'longtitude' => $barangay['longitude'],
            ]);
        }

    }
}