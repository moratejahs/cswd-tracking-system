<?php

namespace App\Services;

use App\Models\Sale;

class SalesAndProfitsReportService
{
    public function getTotalSalesAndProfit()
    {
        $sales = Sale::sum('amount');
        $cost = Sale::with('product')->get()->sum(function ($sale) {
            return $sale->product->cost_price;
        });

        return [
            'sales' => $sales,
            'profit' => $sales - $cost,
        ];
    }

    public function getYearlySalesAndProfit($year)
    {
        $sales = Sale::whereYear('sale_date', $year)->sum('amount');
        $cost = Sale::whereYear('sale_date', $year)->with('product')->get()->sum(function ($sale) {
            return $sale->product->cost_price;
        });

        return [
            'sales' => $sales,
            'profit' => $sales - $cost,
        ];
    }

    public function getMonthlySalesAndProfit($year, $month)
    {
        $sales = Sale::whereYear('sale_date', $year)
            ->whereMonth('sale_date', $month)
            ->sum('amount');
        $cost = Sale::whereYear('sale_date', $year)
            ->whereMonth('sale_date', $month)
            ->with('product')->get()->sum(function ($sale) {
                return $sale->product->cost_price;
            });

        return [
            'sales' => $sales,
            'profit' => $sales - $cost,
        ];
    }

    public function getSalesAndProfitByCategory($categoryId)
    {
        $sales = Sale::whereHas('product', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->sum('amount');
        $cost = Sale::whereHas('product', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->with('product')->get()->sum(function ($sale) {
            return $sale->product->cost_price;
        });

        return [
            'sales' => $sales,
            'profit' => $sales - $cost,
        ];
    }

    public function getSalesAndProfitByProduct($productId)
    {
        $sales = Sale::where('product_id', $productId)->sum('amount');
        $cost = Sale::where('product_id', $productId)
            ->with('product')->get()->sum(function ($sale) {
                return $sale->product->cost_price;
            });

        return [
            'sales' => $sales,
            'profit' => $sales - $cost,
        ];
    }
}
