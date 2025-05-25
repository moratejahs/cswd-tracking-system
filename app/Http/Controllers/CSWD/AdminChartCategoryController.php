<?php

namespace App\Http\Controllers\CSWD;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminChartCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {

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
            'assistances' => $assistancesWithPercentage,
        ]);
    }
}
