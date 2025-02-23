<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AdminQuickSaleRestoreController extends Controller
{
    public function __invoke(string $quickSale)
    {
        try {
            $sale = Sale::withTrashed()->where('id', $quickSale)->firstOrFail();
            $sale->restore();

            return response()->json(['success' => 'Quick sale restored successfully.'], 200);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to restore quick sale.'], 500);
        }
    }
}
