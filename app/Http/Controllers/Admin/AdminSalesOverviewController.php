<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AdminSalesOverviewController extends Controller
{
    public function __invoke(Request $request, AnalyticsService $analyticsService)
    {
        $period = $request->get('period', 'year');
        return response()->json(
            [
                'data' => $analyticsService->getSalesOverview($period)
            ]
        );
    }
}
