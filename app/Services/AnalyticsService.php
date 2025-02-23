<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    // Dashboard Bar Chart
    public function getSalesOverview($period = 'year')
    {
        $salesArray = [];
        $now = Carbon::now();

        switch ($period) {
            case 'year':
                $sales = Sale::whereYear('sale_date', $now->year)
                    ->select(DB::raw('MONTH(sale_date) as period'), DB::raw('COUNT(*) as total_sales'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $periods = [
                    0 => 'Jan',
                    1 => 'Feb',
                    2 => 'Mar',
                    3 => 'Apr',
                    4 => 'May',
                    5 => 'Jun',
                    6 => 'Jul',
                    7 => 'Aug',
                    8 => 'Sep',
                    9 => 'Oct',
                    10 => 'Nov',
                    11 => 'Dec'
                ];

                $salesArray = array_fill_keys($periods, 0);

                foreach ($sales as $sale) {
                    $salesArray[$periods[$sale['period'] - 1]] = $sale['total_sales'];
                }
                break;

            case 'month':
                $sales = Sale::whereYear('sale_date', $now->year)
                    ->whereMonth('sale_date', $now->month)
                    ->select(DB::raw('DAY(sale_date) as period'), DB::raw('COUNT(*) as total_sales'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $periods = range(1, $now->daysInMonth);
                $salesArray = array_fill_keys($periods, 0);

                foreach ($sales as $sale) {
                    $salesArray[$sale['period']] = $sale['total_sales'];
                }
                break;

            case 'day':
                $sales = Sale::whereDate('sale_date', $now)
                    ->select(DB::raw('HOUR(sale_date) as period'), DB::raw('COUNT(*) as total_sales'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $periods = array_map(function ($hour) {
                    return date("g:i A", strtotime($hour . ":00"));
                }, range(0, 23));

                $salesArray = array_fill_keys($periods, 0);

                foreach ($sales as $sale) {
                    $salesArray[date("g:i A", strtotime($sale['period'] . ":00"))] = $sale['total_sales'];
                }
                break;
        }
        return $salesArray;
    }

    public function getRevenueVsProfit($period = 'year')
    {
        $revenueArray = [];
        $profitArray = [];
        $now = Carbon::now();

        switch ($period) {
            case 'year':
                $sales = Sale::whereYear('sale_date', $now->year)
                    ->join('products', 'sales.product_id', '=', 'products.id')
                    ->select(DB::raw('MONTH(sale_date) as period'), DB::raw('SUM((sales.amount / 100)) as total_revenue'), DB::raw('SUM(sales.quantity * (products.cost_price / 100)) as total_cost'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $qsSales = Sale::whereYear('sale_date', $now->year)
                    ->whereNull('product_id')
                    ->select(DB::raw('MONTH(sale_date) as period'), DB::raw('SUM((sales.amount / 100)) as total_revenue'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();


                $periods = [
                    0 => 'Jan',
                    1 => 'Feb',
                    2 => 'Mar',
                    3 => 'Apr',
                    4 => 'May',
                    5 => 'Jun',
                    6 => 'Jul',
                    7 => 'Aug',
                    8 => 'Sep',
                    9 => 'Oct',
                    10 => 'Nov',
                    11 => 'Dec'
                ];

                $revenueArray = array_fill_keys($periods, 0);
                $profitArray = array_fill_keys($periods, 0);

                foreach ($sales as $sale) {
                    $revenueArray[$periods[$sale['period'] - 1]] = round($sale['total_revenue'], 2);
                    $profitArray[$periods[$sale['period'] - 1]] = round($sale['total_revenue'] - $sale['total_cost'], 2);
                }

                foreach ($qsSales as $qsSale) {
                    $revenueArray[$periods[$qsSale['period'] - 1]] += round($qsSale['total_revenue'], 2);
                }
                break;

            case 'month':
                $sales = Sale::whereYear('sale_date', $now->year)
                    ->whereMonth('sale_date', $now->month)
                    ->join('products', 'sales.product_id', '=', 'products.id')
                    ->select(DB::raw('DAY(sale_date) as period'), DB::raw('SUM((sales.amount / 100)) as total_revenue'), DB::raw('SUM(sales.quantity * (products.cost_price / 100)) as total_cost'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $qsSales = Sale::whereYear('sale_date', $now->year)
                    ->whereMonth('sale_date', $now->month)
                    ->whereNull('product_id')
                    ->select(DB::raw('DAY(sale_date) as period'), DB::raw('SUM((sales.amount / 100)) as total_revenue'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $periods = range(1, $now->daysInMonth);
                $revenueArray = array_fill_keys($periods, 0);
                $profitArray = array_fill_keys($periods, 0);

                foreach ($sales as $sale) {
                    $revenueArray[$sale['period']] = round($sale['total_revenue'], 2);
                    $profitArray[$sale['period']] = round($sale['total_revenue'] - $sale['total_cost'], 2);
                }

                foreach ($qsSales as $qsSale) {
                    $revenueArray[$qsSale['period']] += round($qsSale['total_revenue'], 2);
                }
                break;

            case 'day':

                $sales = Sale::whereDate('sale_date', $now)
                    ->join('products', 'sales.product_id', '=', 'products.id')
                    ->select(DB::raw('HOUR(sale_date) as period'), DB::raw('SUM((sales.amount / 100)) as total_revenue'), DB::raw('SUM(sales.quantity * (products.cost_price / 100)) as total_cost'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $qsSales = Sale::whereDate('sale_date', $now)
                    ->whereNull('product_id')
                    ->select(DB::raw('HOUR(sale_date) as period'), DB::raw('SUM((sales.amount / 100)) as total_revenue'))
                    ->groupBy('period')
                    ->get()
                    ->toArray();

                $periods = array_map(function ($hour) {
                    return date("g:i A", strtotime($hour . ":00"));
                }, range(0, 23));

                $revenueArray = array_fill_keys($periods, 0);
                $profitArray = array_fill_keys($periods, 0);

                foreach ($sales as $sale) {
                    $revenueArray[date("g:i A", strtotime($sale['period'] . ":00"))] = round($sale['total_revenue'], 2);
                    $profitArray[date("g:i A", strtotime($sale['period'] . ":00"))] = round($sale['total_revenue'] - $sale['total_cost'], 2);
                }

                foreach ($qsSales as $qsSale) {
                    $revenueArray[date("g:i A", strtotime($qsSale['period'] . ":00"))] += round($qsSale['total_revenue'], 2);
                }
                break;
        }

        return [
            'revenue' => $revenueArray,
            'profit' => $profitArray
        ];
    }

    public function getRevenue()
    {
        // get an array of the total revenue for each month of the current year
        $revenue = Sale::whereYear('sale_date', date('Y'))
            ->select(DB::raw('MONTH(sale_date) as month'), DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        $qsRevenue = Sale::whereYear('sale_date', date('Y'))
            ->whereNull('product_id')
            ->select(DB::raw('MONTH(sale_date) as month'), DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // initialize an array with 12 elements all set to 0
        $revenueArray = array_fill(0, 12, 0);

        // replace the values in the revenueArray with the revenue count from the database
        foreach ($revenue as $month => $rev) {
            // subtract 1 from month because array index starts from 0
            $revenueArray[$month - 1] = $rev['total_revenue'];
        }

        foreach ($qsRevenue as $month => $qsRev) {
            $revenueArray[$month - 1] += $qsRev['total_revenue'];
        }

        return $revenueArray;
    }

    public function getProfit()
    {
        // get an array of the total revenue and cost for each month of the current year
        $sales = Sale::whereYear('sale_date', date('Y'))
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select(DB::raw('MONTH(sale_date) as month'), DB::raw('SUM((sales.amount / 100)) as total_revenue'), DB::raw('SUM(sales.quantity * (products.cost_price / 100)) as total_cost'))
            ->groupBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // $qsSales = Sale::whereYear('sale_date', date('Y'))
        //     ->whereNull('product_id')
        //     ->select(DB::raw('MONTH(sale_date) as month'), DB::raw('SUM((sales.amount / 100)) as total_revenue'))
        //     ->groupBy('month')
        //     ->get()
        //     ->keyBy('month')
        //     ->toArray();

        // initialize an array with 12 elements all set to 0
        $profitArray = array_fill(0, 12, 0);

        // replace the values in the profitArray with the profit for each month
        foreach ($sales as $month => $sale) {
            // subtract 1 from month because array index starts from 0
            $profitArray[$month - 1] = $sale['total_revenue'] - $sale['total_cost'];
        }

        // foreach ($qsSales as $month => $qsSale) {
        //     $profitArray[$month - 1] += $qsSale['total_revenue'];
        // }

        return $profitArray;
    }
}
