<?php

namespace App\Imports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssistanceImport implements ToModel, WithHeadingRow
{
    protected $barangayData = [
        ['name' => 'Awasian Tandag, Surigao del Sur', 'latitude' => '9.071651312307543', 'longitude' => '126.162487818678'],
        ['name' => 'Bagong Lungsod (Poblacion) Tandag, Surigao del Sur', 'latitude' => '9.07840811322997', 'longitude' => '126.1992890639329'],
        ['name' => 'Bioto Tandag, Surigao del Sur', 'latitude' => '9.066121085386317', 'longitude' => '126.1789407724455'],
        ['name' => 'Bungtod Poblacion (East West) Tandag, Surigao del Sur', 'latitude' => '9.084141321839013', 'longitude' => '126.19323166278106'],
        ['name' => 'Buenavista Tandag, Surigao del Sur', 'latitude' => '9.121600152238353', 'longitude' => '126.15983180381019'],
        ['name' => 'Dagocdoc (Poblacion) Tandag, Surigao del Sur', 'latitude' => '9.078319', 'longitude' => '126.194536'],
        ['name' => 'Mabua Tandag, Surigao del Sur', 'latitude' => '9.071682', 'longitude' => '126.205704'],
        ['name' => 'Mabuhay Tandag, Surigao del Sur', 'latitude' => '9.091768', 'longitude' => '126.132823'],
        ['name' => 'Maitum Tandag, Surigao del Sur', 'latitude' => '9.067148', 'longitude' => '126.122245'],
        ['name' => 'Maticdum Tandag, Surigao del Sur', 'latitude' => '9.036726', 'longitude' => '126.151949'],
        ['name' => 'Pandanon Tandag, Surigao del Sur', 'latitude' => '9.056668', 'longitude' => '126.146299'],
        ['name' => 'Pangi Tandag, Surigao del Sucr', 'latitude' => '9.108202', 'longitude' => '126.135623'],
        ['name' => 'Quezon Tandag, Surigao del Sur', 'latitude' => '9.059599', 'longitude' => '126.157458'],
        ['name' => 'Rosario Tandag, Surigao del Sur', 'latitude' => '9.049894', 'longitude' => '126.200565'],
        ['name' => 'Salvacion Tandag, Surigao del Sur', 'latitude' => '9.114638', 'longitude' => '126.147701'],
        ['name' => 'San Agustin Norte Tandag, Surigao del Sur', 'latitude' => '9.095957', 'longitude' => '126.149307'],
        ['name' => 'San Agustin Sur Tandag, Surigao del Sur', 'latitude' => '9.077198', 'longitude' => '126.186401'],
        ['name' => 'San Antonio Tandag, Surigao del Sur', 'latitude' => '9.152063', 'longitude' => '126.162420'],
        ['name' => 'San Isidro Tandag, Surigao del Sur', 'latitude' => '9.044549', 'longitude' => '126.167748'],
        ['name' => 'San Jose Tandag, Surigao del Sur', 'latitude' => '9.046759', 'longitude' => '126.184373'],
        ['name' => 'Telaje Tandag, Surigao del Sur', 'latitude' => '9.062234', 'longitude' => '126.192604'],
    ];

    public function model(array $row)
    {
        try {
            // Debug log the incoming address
            \Log::info('Processing address: ' . ($row['address'] ?? 'not set'));

            // Find barangay data based on the address
            $barangayInfo = $this->findBarangayData($row['address'] ?? '');

            // Debug log the match result
            \Log::info('Barangay match result: ', ['match' => $barangayInfo ? $barangayInfo['name'] : 'no match']);

            return new Assistance([
                'first_name'     => $row['first_name'] ?? null,
                'middle_name'    => $row['middle_name'] ?? null,
                'last_name'      => $row['last_name'] ?? null,
                'birth_date'     => $row['birth_date'] ?? null,
                'age'            => $row['age'] ?? null,
                'gender'         => $row['gender'] ?? null,
                'address'        => $row['address'] ?? null,
                'outlet_name'    => $barangayInfo ? str_replace(' Tandag, Surigao del Sur', '', $barangayInfo['name']) : null,
                'lat'            => $barangayInfo ? $barangayInfo['latitude'] : null,
                'long'           => $barangayInfo ? $barangayInfo['longitude'] : null,
                'contact_no'     => $row['contact_no'] ?? null,
                'occupation'     => $row['occupation'] ?? null,
                'purpose'        => $row['purpose'] ?? null,
                'category'       => $row['category'] ?? null,
                'amount'         => $row['amount'] ?? null,
                'responsible_person' => $row['responsible_person'] ?? null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Import error: ' . $e->getMessage());
            \Log::error('Row data: ' . json_encode($row));
            throw $e;
        }
    }

    private function findBarangayData($address)
    {
        if (empty($address)) {
            \Log::warning('Empty address provided');
            return null;
        }

        // Normalize the address by trimming and converting to lowercase
        $normalizedAddress = strtolower(trim($address));
        \Log::info('Normalized address: ' . $normalizedAddress);

        foreach ($this->barangayData as $barangay) {
            // Extract just the barangay name without the city/province
            $barangayName = str_replace(' Tandag, Surigao del Sur', '', $barangay['name']);
            $normalizedBarangayName = strtolower(trim($barangayName));

            \Log::info('Comparing with: ' . $normalizedBarangayName);

            // Check if the normalized address contains the normalized barangay name
            if (str_contains($normalizedAddress, $normalizedBarangayName)) {
                \Log::info('Match found: ' . $barangay['name']);
                return $barangay;
            }
        }

        \Log::warning('No barangay match found for address: ' . $address);
        return null;
    }
}
