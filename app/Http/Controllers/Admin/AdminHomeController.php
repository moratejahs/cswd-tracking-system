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
        $sanIsidro = Assistance::where('address', 'like', '%San Isidro%')->count();
        $awasian = Assistance::where('address', 'like','%Awasian%')->count();
        $bagongLungsod = Assistance::where('address', 'like','%Bagong Lungsod%')->count();
        $bioto = Assistance::where('address', 'like','%Bioto%')->count();
        $bongtod = Assistance::where('address', 'like','%Bongtud%')->count();
        $buenavista = Assistance::where('address','like', '%Buenavista%')->count();
        $dagocdoc = Assistance::where('address','like', '%Dagocdoc (Poblacion)%')->count();
        $mabua = Assistance::where('address','like', '%Mabua%')->count();
        $mabuhay = Assistance::where('address','like', '%Mabuhay%')->count();
        $maitum = Assistance::where('address','like', '%Maitum%')->count();
        $maticdum = Assistance::where('address','like', '%Maticdum%')->count();
        $pandanon = Assistance::where('address','like', '%Pandanon%')->count();
        $pangi = Assistance::where('address','like', '%Pangi%')->count();
        $quezon = Assistance::where('address','like', '%Quezon%')->count();
        $rosario = Assistance::where('address','like', '%Rosario%')->count();
        $salvacion = Assistance::where('address','like', '%Salvacion%')->count();
        $sanAgustinNorte = Assistance::where('address','like', '%San Agustin Norte%')->count();
        $sanAgustinSur = Assistance::where('address','like', '%San Agustin%')->count();
        $sanAntonio = Assistance::where('address','like', '%San Antonio%')->count();
        $sanJose = Assistance::where('address','like', '%San Jose%')->count();
        $telaje = Assistance::where('address','like', '%Telaje%')->count();

        // $barangays = Barangay::all();
        $categories = ClientCategory::all();
        $populationMapping = [
            'Awasian' => 2040,
            'Bagong Lungsod (Poblacion)' => 5419,
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
            ->select(
                'b.id as barangay_id',
                'b.outlet_address',
                'b.outlet_name',
                'b.latitude',
                'b.longtitude',
                DB::raw('COUNT(a.id) as total_assistance_requests'),
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
            // foreach ($barangays as $barangay) {
            //     if ($barangay->outlet_name === "Bongtud Poblacion (East West)") {
            //         $barangay->outlet_name = "Bongtud Poblacion (East West)";
            //     }
            // }
        // dd($barangays);

        // dd($barangays);

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
        $barangayAssistance = DB::table('assistances')
            ->select(
                'category as assistance',
                'first_name',
                'middle_name',
                'last_name',
                DB::raw('COUNT(*) AS visit_count'),
                DB::raw('SUM(CAST(amount AS DECIMAL(10,2))) AS total_amount')
            )
            ->where('outlet_name', $outlet_name)
            ->groupBy('category', 'first_name', 'middle_name', 'last_name')
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
