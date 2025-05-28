<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubFund;
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
    function getBarangayTotal($barangay)
{
    $assistancesCount = Assistance::where('address', 'like', "%{$barangay}%")->count();

    $subFundsCount = DB::table('sub_funds')
        ->whereIn('assistance_id', function ($query) use ($barangay) {
            $query->select('id')
                  ->from('assistances')
                  ->where('address', 'like', "%{$barangay}%");
        })
        ->count();

    return $assistancesCount + $subFundsCount;
}
    public function index()
    {
        $sanIsidro = $this->getBarangayTotal('San Isidro');
        $awasian = $this->getBarangayTotal('Awasian');
        $bagongLungsod = $this->getBarangayTotal('Bagong Lungsod');
        $bioto = $this->getBarangayTotal('Bioto');
        $bongtod = $this->getBarangayTotal('Bongtud');
        $buenavista = $this->getBarangayTotal('Buenavista');
        $dagocdoc = $this->getBarangayTotal('Dagocdoc (Poblacion)');
        $mabua = $this->getBarangayTotal('Mabua');
        $mabuhay = $this->getBarangayTotal('Mabuhay');
        $maitum = $this->getBarangayTotal('Maitum');
        $maticdum = $this->getBarangayTotal('Maticdum');
        $pandanon = $this->getBarangayTotal('Pandanon');
        $pangi = $this->getBarangayTotal('Pangi');
        $quezon = $this->getBarangayTotal('Quezon');
        $rosario = $this->getBarangayTotal('Rosario');
        $salvacion = $this->getBarangayTotal('Salvacion');
        $sanAgustinNorte = $this->getBarangayTotal('San Agustin Norte');
        $sanAgustinSur = $this->getBarangayTotal('San Agustin'); // Note: May overlap with Norte
        $sanAntonio = $this->getBarangayTotal('San Antonio');
        $sanJose = $this->getBarangayTotal('San Jose');
        $telaje = $this->getBarangayTotal('Telaje');
        // $barangays = Barangay::all();
        $categories = ClientCategory::all();
        $populationMapping = [
            'Awasian' => 2040,
            'Bagong Lungsod' => 5419,
            'Bioto' => 1706,
            'Bongtud' => 6059,
            'Buenavista' => 3256,
            'Dagocdoc' => 3754,
            'Mabua' => 8475,
            'Mabuhay' => 813,
            'Maitum' => 1911,
            'Maticdum' => 844,
            'Pandanon' => 1030,
            'Pangi' => 1028,
            'Quezon' => 1985,
            'Rosario' => 4385,
            'Salvacion' => 896,
            'San Agustin Norte' => 2404,
            'San Agustin Sur' => 5921,
            'San Antonio' => 909,
            'San Isidro' => 1051,
            'San Jose' => 893,
            'Telaje' => 7881,
        ];

        $barangays = DB::table('barangays as b')
            ->leftJoin('assistances as a', 'b.outlet_name', '=', 'a.outlet_name')
            ->leftJoin('sub_funds as sf', 'a.id', '=', 'sf.assistance_id')
            ->select(
                'b.id as barangay_id',
                'b.outlet_address',
                'b.outlet_name',
                'b.latitude',
                'b.longtitude',
                // Count of assistance requests + sub_funds
                DB::raw('COUNT(DISTINCT a.id) + COUNT(DISTINCT sf.id) as total_assistance_requests'),
                // Sum of amounts from assistances and sub_funds
                DB::raw('COALESCE(SUM(CAST(a.amount AS DECIMAL(10,2))),0) + COALESCE(SUM(CAST(sf.amount AS DECIMAL(10,2))),0) as total_amount'),
                DB::raw("CASE ".
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = \"{$address}\" THEN {$population}";
                    }, $populationMapping, array_keys($populationMapping))).
                    " ELSE 10 END as total_population"),
                    DB::raw("ROUND((COUNT(a.id) / " .
                    "CASE " .
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = \"{$address}\" THEN {$population}";
                    }, $populationMapping, array_keys($populationMapping))) .
                    " ELSE 10 END) * 100, 2) as assistance_percentage"),
                DB::raw("CASE ".
                    "WHEN (COUNT(a.id) / ".
                    "CASE ".
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = '".$address."' THEN ".$population;
                    }, $populationMapping, array_keys($populationMapping))).
                    " ELSE 10 END) * 100 >= 75 THEN 'High Assistance (75-100%)' " .
                    "WHEN (COUNT(a.id) / ".
                    "CASE ".
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = '".$address."' THEN ".$population;
                    }, $populationMapping, array_keys($populationMapping))).
                    " ELSE 10 END) * 100 >= 45 THEN 'Medium Assistance (45-74%)' " .
                    "ELSE 'Low Assistance (0-44%)' END as assistance_level"
                )
            )
            ->groupBy('b.id', 'b.outlet_name', 'b.outlet_name', 'b.latitude', 'b.longtitude')
            ->orderBy('b.outlet_name')
            ->get();

        $assistances = DB::table('assistances')
            ->select('category', DB::raw('COUNT(*) as total_per_category'))
            ->groupBy('category')
            ->get();

        $totalCount = DB::table('assistances')->count();

        $assistancesWithPercentage = $assistances->map(function ($item) use ($totalCount) {
            $item->percentage = round(($item->total_per_category / $totalCount) * 100, 2);
            return $item;
        });
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
            'assistances' => $assistancesWithPercentage,
        ]);
    }
    public function getCategoryData(Request $request)
    {
        $category = $request->query('category');

        // Debug output
        \Log::info('Filtering by category:', ['category' => $category]);

        $barangays = [
            'San Isidro',
            'Awasian',
            'Bagong Lungsod (Poblacion)',
            'Bioto',
            'Bongtud',
            'Buenavista',
            'Dagocdoc (Poblacion)',
            'Mabua',
            'Mabuhay',
            'Maitum',
            'Maticdum',
            'Pandanon',
            'Pangi',
            'Quezon',
            'Rosario',
            'Salvacion',
            'San Agustin Norte',
            'San Agustin Sur',
            'San Antonio',
            'San Jose',
            'Telaje',
        ];

        // Fetch counts dynamically based on category and barangay
        $data = [];
        foreach ($barangays as $barangay) {
            $count = Assistance::where('outlet_name', $barangay)
                ->when($category, function($query) use ($category) {
                    return $query->where('category', $category);
                })
                ->count();

            $data[] = $count;
        }

        return response()->json(['values' => $data]);
    }


    public function getBarangayAssistance(string $outlet_name)
    {
        $barangayAssistance = DB::table('assistances as a')
            ->leftJoin('sub_funds as sf', 'a.id', '=', 'sf.assistance_id')
            ->select(
                'a.category as assistance',
                'a.first_name',
                'a.middle_name',
                'a.last_name',
                // Count visits from both assistances and sub_funds
                DB::raw('COUNT(DISTINCT a.id) + COUNT(DISTINCT sf.id) AS visit_count'),
                // Sum amounts from both assistances and sub_funds
                DB::raw('COALESCE(SUM(CAST(a.amount AS DECIMAL(10,2))),0) + COALESCE(SUM(CAST(sf.amount AS DECIMAL(10,2))),0) AS total_amount')
            )
            ->where('a.outlet_name', $outlet_name)
            ->groupBy('a.category', 'a.first_name', 'a.middle_name', 'a.last_name')
            ->orderByDesc('total_amount')
            ->get();
        return response()->json($barangayAssistance);
    }

    public function getBarangayMapData(Request $request)
    {
        $period = $request->query('period', 'all');
        $query = Barangay::query();

        // Example: Adjust this logic to match your actual data structure and date fields
        if ($period === 'week') {
            $query->where('created_at', '>=', now()->startOfWeek());
        } elseif ($period === 'month') {
            $query->where('created_at', '>=', now()->startOfMonth());
        } elseif ($period === 'year') {
            $query->where('created_at', '>=', now()->startOfYear());
        }
        // else 'all' returns all records

        $barangays = $query->get();

        // Optionally, format the data as needed for the frontend
        return response()->json($barangays);
    }


    public function getFilter(Request $request)
    {
        $timeFilter = $request->query('timeFilter');

        $populationMapping = [
            'Awasian' => 2040,
            'Bagong Lungsod (Poblacion)' => 5419,
            'Bioto' => 1706,
            'Bongtud' => 6059,
            'Buenavista' => 3256,
            'Dagocdoc (Poblacion)' => 3754,
            'Mabua' => 8475,
            'Mabuhay' => 813,
            'Maitum' => 1911,
            'Maticdum' => 844,
            'Pandanon' => 1030,
            'Pangi' => 1028,
            'Quezon' => 1985,
            'Rosario' => 4385,
            'Salvacion' => 896,
            'San Agustin Norte' => 2404,
            'San Agustin' => 5921,
            'San Antonio' => 909,
            'San Isidro' => 1051,
            'San Jose' => 893,
            'Telaje' => 7881,
        ];

        $assistancesQuery = DB::table('barangays as b')
            ->leftJoin('assistances as a', 'b.outlet_name', '=', 'a.outlet_name')
            ->select(
                'b.id as barangay_id',
                'b.outlet_address',
                'b.outlet_name',
                'b.latitude',
                'b.longtitude',
                DB::raw('COUNT(a.id) as total_assistance_requests'),
                DB::raw("CASE " .
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = \"{$address}\" THEN {$population}";
                    }, $populationMapping, array_keys($populationMapping))) .
                    " ELSE 10 END as total_population"),
                DB::raw("ROUND((COUNT(a.id) / " .
                    "CASE " .
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = \"{$address}\" THEN {$population}";
                    }, $populationMapping, array_keys($populationMapping))) .
                    " ELSE 10 END) * 100, 2) as assistance_percentage"),
                DB::raw("CASE " .
                    "WHEN (COUNT(a.id) / " .
                    "CASE " .
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = \"{$address}\" THEN {$population}";
                    }, $populationMapping, array_keys($populationMapping))) .
                    " ELSE 10 END) * 100 >= 75 THEN 'High Assistance (75-100%)' " .
                    "WHEN (COUNT(a.id) / " .
                    "CASE " .
                    implode(" ", array_map(function ($population, $address) {
                        return "WHEN b.outlet_name = \"{$address}\" THEN {$population}";
                    }, $populationMapping, array_keys($populationMapping))) .
                    " ELSE 10 END) * 100 >= 45 THEN 'Medium Assistance (45-74%)' " .
                    "ELSE 'Low Assistance (0-44%)' END as assistance_level"
                )
            )
            ->when($timeFilter, function ($query) use ($timeFilter) {
                switch ($timeFilter) {
                    case 'week':
                        $query->whereBetween('a.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('a.created_at', now()->month)
                            ->whereYear('a.created_at', now()->year);
                        break;
                    case 'year':
                        $query->whereYear('a.created_at', now()->year);
                        break;
                    case 'all':
                    default:
                        // No time filter
                        break;
                }
            })
            ->groupBy('b.id', 'b.outlet_name', 'b.outlet_address', 'b.latitude', 'b.longtitude')
            ->orderBy('b.outlet_name');

        $result = $assistancesQuery->get();

        return response()->json(['values' => $result]);
    }

}
