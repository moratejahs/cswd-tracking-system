<?php

namespace App\Imports;

use App\Models\BarangayAssitant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangayAssitanceImport implements ToModel, WithHeadingRow
{
    private $assistance;
    private $barangayData;

    public function __construct($assistance)
    {
        $this->assistance = $assistance;
        $this->barangayData = [
            ['name' => 'Awasian', 'latitude' => '9.071651312307543', 'longitude' => '126.162487818678'],
            ['name' => 'Bagong Lungsod (Poblacion)', 'latitude' => '9.07840811322997', 'longitude' => '126.1992890639329'],
            ['name' => 'Bioto', 'latitude' => '9.066121085386317', 'longitude' => '126.1789407724455'],
            ['name' => 'Bungtod Poblacion (East West)', 'latitude' => '9.084141321839013', 'longitude' => '126.19323166278106'],
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
    }

    public function model(array $row)
    {
        try {
            $barangayInfo = $this->findBarangayData($row['Address']);

            if (!$barangayInfo) {
                return null;
            }

            return new BarangayAssitant([
                'assistance_id' => $this->assistance->id,
                'outlet_name' => $barangayInfo['name'],
                'outlet_address' => $row['Address'] . " Tandag, Surigao del Sur",
                'lat' => $barangayInfo['latitude'],
                'long' => $barangayInfo['longitude'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Barangay Import Error: ' . $e->getMessage());
            \Log::error('Row Data: ' . json_encode($row));
            throw $e;
        }
    }

    private function findBarangayData($address)
    {
        foreach ($this->barangayData as $barangay) {
            if (stripos($address, $barangay['name']) !== false) {
                return $barangay;
            }
        }
        return null;
    }
}
