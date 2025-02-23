<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\AnalyticsService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BarangayAssitance;
use Carbon\Carbon;

class AdminHomeController extends Controller
{
    protected $analyticsService;
    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
           // Fetch data grouped by month
           $monthlyData = BarangayAssitance::selectRaw("
                MONTH(created_at) as month,
                COUNT(CASE WHEN status = 'done' THEN 1 END) as done,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

   // Define all months to prevent missing months in chart
            $allMonths = collect([
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ]);

            // Prepare data
            $doneData = array_fill(0, 12, 0); // Default values as 0
            $pendingData = array_fill(0, 12, 0);

            foreach ($monthlyData as $data) {
                $monthIndex = $data->month - 1; // Convert month number to array index (0-based)
                $doneData[$monthIndex] = $data->done;
                $pendingData[$monthIndex] = $data->pending;
            }
        return view('admin.admin-dashboard', compact('allMonths', 'doneData', 'pendingData'));
    }
}