<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($supplierName)
    {
        $products = DB::table('products as pro')
            ->select(
                'pro.id as product_id',
                'pro.code',
                'pro.product_name',
                'pro.supplier_name',

                'pro.unit',
                'pro.quantity',
                DB::raw('(pro.quantity - COALESCE(SUM(sales.quantity), 0)) as remaining_qty'),
                DB::raw('(pro.cost_price / 100) as cost_price'),
                DB::raw('(pro.sell_price / 100) as sell_price'),
                DB::raw("CASE
                WHEN (pro.quantity - COALESCE(SUM(sales.quantity), 0)) = 0 THEN 'Out of Stock'
                WHEN (pro.quantity - COALESCE(SUM(sales.quantity), 0)) < 20 THEN 'Low Stock'
                ELSE 'In-Stock'
                END AS stock_status"),
                DB::raw("CASE
                    WHEN (pro.quantity - COALESCE(SUM(sales.quantity), 0)) = 0 THEN 'badge bg-danger'
                    WHEN (pro.quantity - COALESCE(SUM(sales.quantity), 0)) < 20 THEN 'badge bg-warning'
                ELSE 'badge bg-primary'
                END AS stock_status_css")
            )
            ->leftJoin('categories as cat', 'cat.id', '=', 'pro.category_id')
            ->leftJoin('sales', 'sales.product_id', '=', 'pro.id')
            ->where('pro.supplier_name', $supplierName)
            ->whereNull('pro.deleted_at')
            ->groupBy('pro.code', 'pro.id', 'pro.product_name', 'cat.category_name', 'pro.unit', 'pro.cost_price', 'pro.sell_price', 'pro.quantity')
            ->get();
        $supplier = $supplierName;
        return view('admin.admin-supplier', compact('products', 'supplier'));
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
        //
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
