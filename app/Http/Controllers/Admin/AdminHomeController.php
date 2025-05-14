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
            'Awasian' => 50,
            'Bagong Lungsod (Poblacion)' => 100,
            'Bioto' => 40,
            'Bongtud Poblacion (East West)' => 120,
            'Buenavista' => 70,
            'Dagocdoc (Poblacion)' => 80,
            'Mabua' => 170,
            'Mabuhay' => 20,
            'Maitum' => 40,
            'Maticdum' => 20,
            'Pandanon' => 40,
            'Pangi' => 20,
            'Quezon' => 40,
            'Rosario' => 90,
            'Salvacion' => 20,
            'San Agustin Norte' => 50,
            'San Agustin' => 120,
            'San Antonio' => 20,
            'San Isidro' => 20,
            'San Jose' => 20,
            'Telaje' => 160,
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


    /**
     * Get assistance details for a specific barangay
     *
     * @param string $outlet_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBarangayAssistance($outlet_name)
    {
        try {
            // Decode URL-encoded outlet name
            $outlet_name = urldecode($outlet_name);

            // Query to get assistance details for the barangay
            // Group by client to count visits and sum amounts
            $assistanceDetails = DB::table('assistances')
                ->select(
                    'first_name',
                    'middle_name',
                    'last_name',
                    'category as assistance',
                    DB::raw('COUNT(*) as visit_count'),
                    DB::raw('SUM(CAST(amount as DECIMAL(10,2))) as total_amount')
                )
                ->where('outlet_name', $outlet_name)
                ->groupBy('first_name', 'middle_name', 'last_name', 'category')
                ->orderBy('total_amount', 'desc')
                ->get();

            return response()->json($assistanceDetails);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error fetching barangay details: ' . $e->getMessage());

            // Return a proper JSON error response
            return response()->json([
                'error' => 'Failed to fetch barangay details',
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
