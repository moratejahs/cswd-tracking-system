<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Barangay;
use App\Models\Assistance;
use Illuminate\Http\Request;
use App\Models\BarangayAssitance;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ClientCategory;

class AdminHomeController extends Controller
{
    public function index()
    {
        $sanIsidro = Assistance::where('address', 'San Isidro Tandag, Surigao del Sur')->count();
        $awasian = Assistance::where('address', 'Awasian Tandag, Surigao del Sur')->count();
        $bagongLungsod = Assistance::where('address', 'Bagong Lungsod (Poblacion) Tandag, Surigao del Sur')->count();
        $bioto = Assistance::where('address', 'Bioto Tandag, Surigao del Sur')->count();
        $bongtod = Assistance::where('address', 'Bongtud Poblacion (East West) Tandag, Surigao del Sur')->count();
        // dd($bongtod);
        $buenavista = Assistance::where('address', 'Buenavista Tandag, Surigao del Sur')->count();
        $dagocdoc = Assistance::where('address', 'Dagocdoc (Poblacion) Tandag, Surigao del Sur')->count();
        $mabua = Assistance::where('address', 'Mabua Tandag, Surigao del Sur')->count();
        $mabuhay = Assistance::where('address', 'Mabuhay Tandag, Surigao del Sur')->count();
        $maitum = Assistance::where('address', 'Maitum Tandag, Surigao del Sur')->count();
        $maticdum = Assistance::where('address', 'Maticdum Tandag, Surigao del Sur')->count();
        $pandanon = Assistance::where('address', 'Pandanon Tandag, Surigao del Sur')->count();
        $pangi = Assistance::where('address', 'Pangi Tandag, Surigao del Sur')->count();
        $quezon = Assistance::where('address', 'Quezon Tandag, Surigao del Sur')->count();
        $rosario = Assistance::where('address', 'Rosario Tandag, Surigao del Sur')->count();
        $salvacion = Assistance::where('address', 'Salvacion Tandag, Surigao del Sur')->count();
        $sanAgustinNorte = Assistance::where('address', 'San Agustin Norte Tandag, Surigao del Sur')->count();
        $sanAgustinSur = Assistance::where('address', 'San Agustin Sur Tandag, Surigao del Sur')->count();
        $sanAntonio = Assistance::where('address', 'San Antonio Tandag, Surigao del Sur')->count();
        $sanJose = Assistance::where('address', 'San Jose Tandag, Surigao del Sur')->count();
        $telaje = Assistance::where('address', 'Telaje Tandag, Surigao del Sur')->count();
        // $barangays = Barangay::all();


        $categories = ClientCategory::all();
        $populationMapping = [
            'Awasian Tandag, Surigao del Sur' => 50,
            'Bagong Lungsod (Poblacion) Tandag, Surigao del Sur' => 100,
            'Bioto Tandag, Surigao del Sur' => 40,
            'Bongtud Poblacion (East West) Tandag, Surigao del Sur' => 120,
            'Buenavista Tandag, Surigao del Sur' => 70,
            'Dagocdoc (Poblacion) Tandag, Surigao del Sur' => 80,
            'Mabua Tandag, Surigao del Sur' => 170,
            'Mabuhay Tandag, Surigao del Sur' => 20,
            'Maitum Tandag, Surigao del Sur' => 40,
            'Maticdum Tandag, Surigao del Sur' => 20,
            'Pandanon Tandag, Surigao del Sur' => 40,
            'Pangi Tandag, Surigao del Sur' => 20,
            'Quezon Tandag, Surigao del Sur' => 40,
            'Rosario Tandag, Surigao del Sur' => 90,
            'Salvacion Tandag, Surigao del Sur' => 20,
            'San Agustin Norte Tandag, Surigao del Sur' => 50,
            'San Agustin Sur Tandag, Surigao del Sur' => 120,
            'San Antonio Tandag, Surigao del Sur' => 20,
            'San Isidro Tandag, Surigao del Sur' => 20,
            'San Jose Tandag, Surigao del Sur' => 20,
            'Telaje Tandag, Surigao del Sur' => 160,
        ];

        $barangays = DB::table('barangays as b')
            ->leftJoin('assistances as a', 'b.outlet_address', '=', 'a.address')
            ->select(
                'b.id as barangay_id',
                'b.outlet_address',
                'b.outlet_name',
                'b.latitude',
                'b.longtitude',
                DB::raw('COUNT(a.id) as total_assistance_requests'),
                DB::raw("CASE ".
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_address = '".$address."' THEN ".$population;
                    }, $populationMapping, array_keys($populationMapping))).
                    " ELSE 10 END as total_population"),
                    DB::raw("ROUND((COUNT(a.id) / " .
                    "CASE " .
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_address = '".$address."' THEN ".$population;
                    }, $populationMapping, array_keys($populationMapping))) .
                    " ELSE 10 END) * 100, 2) as assistance_percentage"),
                DB::raw("CASE ".
                    "WHEN (COUNT(a.id) / ".
                    "CASE ".
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_address = '".$address."' THEN ".$population;
                    }, $populationMapping, array_keys($populationMapping))).
                    " ELSE 10 END) * 100 >= 75 THEN 'High Assistance (75-100%)' " .
                    "WHEN (COUNT(a.id) / ".
                    "CASE ".
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_address = '".$address."' THEN ".$population;
                    }, $populationMapping, array_keys($populationMapping))).
                    " ELSE 10 END) * 100 >= 45 THEN 'Medium Assistance (45-74%)' " .
                    "ELSE 'Low Assistance (0-44%)' END as assistance_level"
                )
            )
            ->groupBy('b.id', 'b.outlet_address', 'b.outlet_name', 'b.latitude', 'b.longtitude')
            ->orderBy('b.outlet_address')
            ->get();
            // foreach ($barangays as $barangay) {
            //     if ($barangay->outlet_name === "Bongtud Poblacion (East West)") {
            //         $barangay->outlet_name = "Bongtud Poblacion (East West)";
            //     }
            // }

        // dd($barangays);
        return view('admin.admin-dashboard', [
            'categories' => $categories,
            'sanIsidro' => $sanIsidro,
            'awasian' => $awasian,
            'bagongLungsod' => $bagongLungsod,
            'bioto' => $bioto,
            'bongtod' => $bongtod,
            'buenavista' => $buenavista,
            'dagocdoc' => $dagocdoc,
            'mabua' => $mabua,
            'mabuhay' => $mabuhay,
            'maitum' => $maitum,
            'maticdum' => $maticdum,
            'pandanon' => $pandanon,
            'pangi' => $pangi,
            'quezon' => $quezon,
            'rosario' => $rosario,
            'salvacion' => $salvacion,
            'sanAgustinNorte' => $sanAgustinNorte,
            'sanAgustinSur' => $sanAgustinSur,
            'sanAntonio' => $sanAntonio,
            'sanJose' => $sanJose,
            'telaje' => $telaje,
            'barangays' => $barangays,

        ]);
    }
    public function getCategoryData(Request $request)
    {
        $category = $request->query('category'); // Get the selected category

        // List of barangays
        $barangays = [
            'San Isidro Tandag, Surigao del Sur',
            'Awasian Tandag, Surigao del Sur',
            'Bagong Lungsod (Poblacion) Tandag, Surigao del Sur',
            'Bioto Tandag, Surigao del Sur',
            'Bongtud Poblacion (East West) Tandag, Surigao del Sur',
            'Buenavista Tandag, Surigao del Sur',
            'Dagocdoc (Poblacion) Tandag, Surigao del Sur',
            'Mabua Tandag, Surigao del Sur',
            'Mabuhay Tandag, Surigao del Sur',
            'Maitum Tandag, Surigao del Sur',
            'Maticdum Tandag, Surigao del Sur',
            'Pandanon Tandag, Surigao del Sur',
            'Pangi Tandag, Surigao del Sur',
            'Quezon Tandag, Surigao del Sur',
            'Rosario Tandag, Surigao del Sur',
            'Salvacion Tandag, Surigao del Sur',
            'San Agustin Norte Tandag, Surigao del Sur',
            'San Agustin Sur Tandag, Surigao del Sur',
            'San Antonio Tandag, Surigao del Sur',
            'San Jose Tandag, Surigao del Sur',
            'Telaje Tandag, Surigao del Sur',
        ];

        // Fetch counts dynamically based on category and barangay
        $data = [];
        foreach ($barangays as $barangay) {
            $data[] = Assistance::where('address', $barangay)
                ->when($category, fn($query) => $query->where('assistance', $category)) // Filter by category if set
                ->count();
        }

        return response()->json(['values' => $data]);
    }
        public function getBarangayAssistance(string $address)
    {
        $barangayAssistance = Assistance::select(
            'assistance',
            DB::raw('GROUP_CONCAT(first_name SEPARATOR ", ") as first_names'),
            DB::raw('GROUP_CONCAT(middle_name SEPARATOR ", ") as middle_names'),
            DB::raw('GROUP_CONCAT(last_name SEPARATOR ", ") as last_names'),
            DB::raw('GROUP_CONCAT(last_name SEPARATOR ", ") as last_names'),
            DB::raw('SUM(quantity) as total_quantity'),
            // DB::raw('SUM(total_quantity) as total_quantity')
        )
            ->where('address', $address)
            ->groupBy('assistance', 'first_name', 'middle_name', 'last_name', 'quantity')
            ->get();
        return response()->json($barangayAssistance);

    }
}
