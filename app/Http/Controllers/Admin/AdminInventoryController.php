<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\InventoryReportService;
use Yajra\DataTables\Facades\DataTables;

class AdminInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $inventoryReportService;
    public function __construct(InventoryReportService $inventoryReportService)
    {
        $this->inventoryReportService = $inventoryReportService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select(
                'products.id as product_id',
                'products.code',
                'products.product_name',
                'products.supplier_name',
                'products.unit',
                'products.quantity',
                DB::raw('(products.quantity - COALESCE(SUM(sales.quantity), 0)) as remaining_qty'),
                DB::raw('(products.cost_price) as cost_price'),
                DB::raw('(products.sell_price) as sell_price'),
                DB::raw('(products.sell_price_two) as sell_price_two'),
                DB::raw("CASE
                WHEN products.quantity  = 0 THEN 'Out of Stock'
                WHEN products.quantity  <= 20 THEN 'Low Stock'
                ELSE 'In-Stock'
                END AS stock_status"),
                DB::raw("CASE
                WHEN products.quantity = 0 THEN 'badge bg-danger'
                WHEN products.quantity <= 20 THEN 'badge bg-warning'
                ELSE 'badge bg-primary'
                END AS stock_status_css")
            )
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->leftJoin('sales', 'sales.product_id', '=', 'products.id')
                ->whereNull('products.deleted_at')
                ->groupBy('products.id', 'products.code', 'products.product_name', 'categories.category_name', 'products.unit', 'products.cost_price', 'products.sell_price', 'products.quantity')
                ->get();

            return Datatables::of($data)
                ->addColumn('status', function ($product) {
                    return '<td class="text-center"><small><span class="' . $product->stock_status_css . '">' . $product->stock_status . '</span></small></td>';
                })
                ->addColumn('action', function ($product) {
                    return '<a id="add-product-stock-in" href="javascript:void(0)"
                            data-url="' . route('get.inventory', $product->product_id) . '"
                            class="btn btn-success rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Add Stock">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                        <a id="edit-product" href="javascript:void(0)"
                            data-url="' . route('get.inventory', $product->product_id) . '"
                            class="btn btn-warning rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Product">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a id="remove-product" href="javascript:void(0)"
                            data-url="' . route('get.inventory', $product->product_id) . '"
                            class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Product">
                            <i class="bi bi-trash"></i>
                        </a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.admin-inventory');
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
            'product_name' => 'required',
            'supplier_name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'sell_price' => 'nullable',
            'sell_price_two' => 'nullable',
            'cost_price' => 'nullable',

        ]);

        $categoryId = 1;
        // dd($validated['product_name']);
        try {
            $this->inventoryReportService->storeInventoryProduct(
                '',
                $validated['product_name'],
                $validated['supplier_name'],
                $validated['quantity'],
                $validated['unit'],
                $validated['sell_price'],
                $validated['sell_price_two'],
                $validated['cost_price'],
                $categoryId,
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
            'product_name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'sell_price' => 'required',
            'sell_price_two' => 'required',
            'cost_price' => 'required',
        ]);
        try {
            $this->inventoryReportService->updateInventoryProduct(
                $validated['id'],
                $validated['product_name'],
                $validated['quantity'],
                $validated['unit'],
                $validated['sell_price'],
                $validated['sell_price_two'],
                $validated['cost_price']
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
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        try {
            $this->inventoryReportService->destroyProduct($validated['id']);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return redirect()->back();
    }


    public function restoreIndex()
    {
        $products = DB::table('products as pro')
            ->select(
                'pro.id as product_id',
                'pro.product_name',
                'cat.category_name',
                'pro.unit',
                'pro.quantity',
                'pro.cost_price',
                DB::raw('(pro.sell_price / 100) as sell_price'),
                DB::raw("CASE
                    WHEN pro.quantity = 0 THEN 'Out of Stock'
                    WHEN pro.quantity < 20 THEN 'Low Stock'
                    ELSE 'In-Stock'
                END AS stock_status"),
                DB::raw("CASE
                    WHEN pro.quantity = 0 THEN 'badge bg-danger'
                    WHEN pro.quantity < 20 THEN 'badge bg-warning'
                ELSE 'badge bg-primary'
                END AS stock_status_css")
            )
            ->leftJoin('categories as cat', 'cat.id', '=', 'pro.category_id')
            ->whereNotNull('pro.deleted_at')
            ->get();

        return view('admin.admin-archive-inventory', compact('products'));
    }
    public function restore(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        try {
            $this->inventoryReportService->restoreProduct($validated['id']);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return redirect()->back();
    }

}
