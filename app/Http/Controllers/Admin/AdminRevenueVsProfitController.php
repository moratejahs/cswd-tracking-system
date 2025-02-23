<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AnalyticsService;
use App\Http\Controllers\Controller;

class AdminRevenueVsProfitController extends Controller
{
    public function __invoke(Request $request, AnalyticsService $analyticsService)
    {
        $period = $request->get('period', 'year');
        return response()->json(
            [
                'data' => $analyticsService->getRevenueVsProfit($period)
            ]
        );
    }
}
