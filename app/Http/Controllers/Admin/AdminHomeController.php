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

class AdminHomeController extends Controller
{
    public function index()
    {
        $sanIsidro = Assistance::where('address', 'San Isidro Tandag, Surigao del Sur')->count();
        $awasian = Assistance::where('address', 'Awasian Tandag, Surigao del Sur')->count();
        $bagongLungsod = Assistance::where('address', 'Bagong Lungsod (Poblacion) Tandag, Surigao del Sur')->count();
        $bioto = Assistance::where('address', 'Bioto Tandag, Surigao del Sur')->count();
        $bongtod = Assistance::where('address', 'Bongtod Poblacion (East West) Tandag, Surigao del Sur')->count();
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
        $barangays = Barangay::all();

        return view('admin.admin-dashboard', [
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
            'barangays' => $barangays
        ]);
    }

    public function getBarangayAssistance(string $address)
    {
        $barangayAssistance = Assistance::select('assistance', DB::raw('COUNT(id) as total_quantity'))
        ->groupBy('assistance')
        ->get();
        return response()->json($barangayAssistance);
    }
}
