<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\InventoryReportService;

class AdminCategoryController extends Controller
{
    protected $inventoryReportService;
    public function __construct(InventoryReportService $inventoryReportService)
    {
        $this->inventoryReportService = $inventoryReportService;
    }
    /**
     * Display a listing of the resource.
     */

    public function index($categoryName)
    {
        $category = $categoryName;
        $products = DB::table('products as pro')
            ->select(
                'pro.id as product_id',
                'pro.product_name',
                'cat.category_name',
                'pro.unit',
                'pro.quantity',
                'pro.cost_price',
                'pro.sell_price',
                DB::raw("CASE
                WHEN pro.quantity = 0 THEN 'Out of Stock'
                WHEN pro.quantity < 10 THEN 'Low Stock'
                ELSE 'In-Stock'
            END AS stock_status"),
                DB::raw("CASE
                WHEN pro.quantity = 0 THEN 'badge bg-danger'
                WHEN pro.quantity < 10 THEN 'badge bg-warning'
            ELSE 'badge bg-primary'
            END AS stock_status_css")
            )
            ->leftJoin('categories as cat', 'cat.id', '=', 'pro.category_id')
            ->where('cat.category_name', $category)
            ->get();

        return view('admin.admin-category', compact('products', 'category'));
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
            'category_name' => 'required',
        ]);
        $this->inventoryReportService->storeInventoryCategory($validated['category_name']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
