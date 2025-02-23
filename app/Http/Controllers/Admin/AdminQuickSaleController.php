<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AdminQuickSaleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_desc' => 'required',
            'quantity' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ]);

        try {
            if (!User::find(auth()->user()->id)) {
                return response()->json([
                    'error' => 'Invalid user',
                ], 400);
            }

            Sale::create([
                'quantity' => $validated['quantity'],
                'amount' => $validated['amount'],
                'sale_date' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'qs_product_desc' => $validated['product_desc'],
            ]);

            return response()->json([
                'success' => 'Sale added successfully',
            ], 200);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Something went wrong',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $quickSale)
    {
        try {
            $sale = Sale::findOrFail($quickSale);
            $sale->delete();

            return response()->json([
                'success' => 'Sale deleted successfully',
            ], 200);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Something went wrong',
            ], 500);
        }
    }
}
