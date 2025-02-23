<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\InventoryReportService;
use Exception;

class AdminProductInventoryStockInController extends Controller
{

    protected $inventoryReportService;
    public function __construct(InventoryReportService $inventoryReportService)
    {
        $this->inventoryReportService = $inventoryReportService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = DB::table('products as pro')
            ->select(
                'pro.id as product_id',
                'pro.product_name',
                'cat.category_name',
                'pro.unit',
                'pro.quantity',
                'pro.cost_price',
                'pro.sell_price'
            )
            ->leftJoin('categories as cat', 'cat.id', '=', 'pro.category_id')
            ->get();
        return view('admin.admin-product-inventory-stock-in', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'val_quantity' => 'required',
            'new_stock' => 'required',
        ]);

        try {
            $this->inventoryReportService->storeInventoryProductStockIn(
                $validated['id'],
                $validated['val_quantity'],
                $validated['new_stock']
            );
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $productId)
    {
        $getProductRecord = $this->inventoryReportService->getInventoryByProduct($productId);
        return response()->json($getProductRecord);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'quantity' => 'required'
        ]);
        try {
            $this->inventoryReportService->editInventoryProductStockIn(
                $validated['id'],
                $validated['quantity']
            );
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
