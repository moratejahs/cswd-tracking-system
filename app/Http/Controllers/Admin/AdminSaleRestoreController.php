<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminSaleRestoreController extends Controller
{
    public function __invoke(string $saleId)
    {
        try {
            $sale = Sale::withTrashed()->findOrFail($saleId);
            $product = Product::findOrFail($sale->product_id);

            if ($product->quantity < $sale->quantity) {
                return response()->json(['error' => 'Product quantity is less than the sale quantity'], 400);
            }

            $product->quantity -= $sale->quantity;
            $product->save();
            $sale->restore();

            return response()->json(['success' => 'Sale restored successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Sale not found'], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while restoring sale'], 500);
        }
    }
}
