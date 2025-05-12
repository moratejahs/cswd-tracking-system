<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangayAssitant;
use Illuminate\Http\Request;
use Phpml\Classification\KNearestNeighbors;

class AdminKnnAlgorithm extends Controller
{
    public function index(Request $request)
    {
        // Get all barangay locations
        $barangays = BarangayAssitant::all();

        // Prepare data for clustering
        $locations = [];
        foreach ($barangays as $barangay) {
            if (!$barangay->lat || !$barangay->long) {
                continue;
            }

            $key = $this->getClusterKey($barangay->lat, $barangay->long);
            if (!isset($locations[$key])) {
                $locations[$key] = [
                    'coordinates' => [
                        'lat' => floatval($barangay->lat),
                        'long' => floatval($barangay->long)
                    ],
                    'barangays' => []
                ];
            }

            $locations[$key]['barangays'][] = [
                'name' => $barangay->outlet_name,
                'address' => $barangay->outlet_address,
                'exact_coordinates' => [
                    'lat' => floatval($barangay->lat),
                    'long' => floatval($barangay->long)
                ]
            ];
        }

        // Calculate cluster statistics
        $clusters = [];
        foreach ($locations as $key => $cluster) {
            $clusterSize = count($cluster['barangays']);
            $clusters[] = [
                'center' => $cluster['coordinates'],
                'size' => $clusterSize,
                'barangays' => $cluster['barangays'],
                'average_distance' => $this->calculateAverageDistance($cluster['barangays'])
            ];
        }

        // Sort clusters by size
        usort($clusters, function($a, $b) {
            return $b['size'] <=> $a['size'];
        });

        if ($request->ajax()) {
            return response()->json([
                'clusters' => $clusters
            ]);
        }

        return view('admin.knn.index', [
            'clusters' => $clusters
        ]);
    }

    private function getClusterKey($lat, $long, $precision = 4)
    {
        // Round coordinates to group similar locations
        $roundedLat = round(floatval($lat), $precision);
        $roundedLong = round(floatval($long), $precision);
        return "{$roundedLat}_{$roundedLong}";
    }

    private function calculateAverageDistance($barangays)
    {
        if (count($barangays) <= 1) {
            return 0;
        }

        $totalDistance = 0;
        $count = 0;

        // Calculate average distance between all points in cluster
        for ($i = 0; $i < count($barangays); $i++) {
            for ($j = $i + 1; $j < count($barangays); $j++) {
                $distance = $this->calculateDistance(
                    [$barangays[$i]['exact_coordinates']['lat'], $barangays[$i]['exact_coordinates']['long']],
                    [$barangays[$j]['exact_coordinates']['lat'], $barangays[$j]['exact_coordinates']['long']]
                );
                $totalDistance += $distance;
                $count++;
            }
        }

        return $count > 0 ? round($totalDistance / $count, 2) : 0;
    }

    private function calculateDistance($point1, $point2)
    {
        // Haversine formula for calculating distance between two points on Earth
        $earthRadius = 6371; // Earth's radius in kilometers

        $lat1 = deg2rad($point1[0]);
        $lon1 = deg2rad($point1[1]);
        $lat2 = deg2rad($point2[0]);
        $lon2 = deg2rad($point2[1]);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius, 2); // Return distance in kilometers with 2 decimal places
    }
}
