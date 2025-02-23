<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\InventoryReportService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminSaleController extends Controller
{
    protected $inventoryReportService;
    public function __construct(InventoryReportService $inventoryReportService)
    {
        $this->inventoryReportService = $inventoryReportService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Sale::select([
                'sales.id as sales_id',
                'sales.product_id as product_id',
                DB::raw('CASE WHEN sales.product_id IS NULL THEN sales.qs_product_desc ELSE products.product_name END as product_name'),
                'categories.category_name',
                'products.unit',
                'products.code',
                'products.supplier_name',
                'sales.quantity',
                'sales.sale_date',
                DB::raw('ROUND(sales.amount, 2) as amount'),
                DB::raw('ROUND(products.sell_price / 100, 2) as sell_price'),
            ])
                ->leftJoin('products', 'products.id', '=', 'sales.product_id')
                ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->orderBy('sales.id', 'desc')
                ->whereNull('sales.deleted_at');

            return DataTables::of($data)
                ->addColumn('unit_price', function ($sales) {
                    return $sales->product_id !== null ? $sales->sell_price : 'N/A';
                })
                ->addColumn('action', function ($sales) {
                    return $sales->product_id !== null ? '<a id="edit-sales" href="javascript:void(0)" data-sale-id="' . $sales->sales_id . '"
                                data-url="' . route('sales.show', $sales->sales_id) . '"
                                class="btn btn-warning rounded-pill btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="remove-sales" href="javascript:void(0)" data-sale-id="' . $sales->sales_id . '"
                                data-url="' . route('sales.show', $sales->sales_id) . '"
                                class="btn btn-danger rounded-pill btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>' :
                        '<a id="remove-quick-sale" href="javascript:void(0)" data-sale-id="' . $sales->sales_id . '"
                                data-url="' . route('sales.show', $sales->sales_id) . '"
                                class="btn btn-danger rounded-pill btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>';
                })
                ->rawColumns(['unit_price', 'action'])
                ->make(true);
        }

        $grandTotal = Sale::selectRaw('SUM(sales.amount) as total_sales')->first();
        return view('admin.admin-sales', compact('grandTotal'));
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
            'sell_price_used' => 'required',
        ]);

        try {
            $redirectUrl = route('sales.index');

            if (!User::find(auth()->user()->id)) {
                return response()->json([
                    'error' => 'Invalid user',
                    'redirect' => $redirectUrl
                ], 400);
            }

            $product = Product::findOrFail($validated['product_id']);

            if ($product->quantity < $validated['quantity']) {
                return response()->json([
                    'error' => 'Insufficient stock',
                    'redirect' => $redirectUrl
                ], 400);
            }

            $product->quantity -= $validated['quantity'];
            $product->save();

            Sale::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'amount' => $validated['amount'],
                'sale_date' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'sell_price_used' => $validated['sell_price_used']
            ]);

            return response()->json([
                'success' => 'Sale added successfully',
                'redirect' => $redirectUrl
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Invalid product',
                'redirect' => $redirectUrl
            ], 400);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Something went wrong',
                'redirect' => $redirectUrl
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($saleId)
    {
        $getSale = $this->inventoryReportService->getSale($saleId);
        return response()->json($getSale);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $saleId)
    {
        return Sale::with('product')->findOrFail($saleId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $saleId, Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ]);

        try {
            $sale = Sale::with('product')->findOrFail($saleId);
            $product = Product::findOrFail($validated['product_id']);

            if ($sale->product_id == $validated['product_id'] && $sale->quantity == $validated['quantity'] && $sale->amount == $validated['amount']) {
                return response()->json([
                    'error' => 'No changes made',
                ], 400);
            }

            $product->quantity += $sale->quantity;

            if ($product->quantity < $validated['quantity']) {
                return response()->json([
                    'error' => 'Insufficient stock',
                ], 400);
            }

            $product->quantity -= $validated['quantity'];
            $product->save();

            $sale->update($validated);

            return response()->json([
                'success' => 'Sale updated successfully',
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
    public function destroy(string $saleId)
    {
        try {
            $redirectUrl = route('sales.index');

            $sale = Sale::findOrFail($saleId);
            $product = Product::findOrFail($sale->product_id);
            $product->quantity += $sale->quantity;
            $product->save();
            $sale->delete();

            return response()->json([
                'success' => 'Sale deleted successfully',
                'redirect' => $redirectUrl
            ], 200);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Something went wrong',
                'redirect' => $redirectUrl
            ], 500);
        }
    }

    public function restoreIndex()
    {
        $sales = DB::table('sales')
            ->select([
                'sales.id as sales_id',
                'sales.product_id as product_id',
                'products.product_name',
                'categories.category_name',
                'products.unit',
                'sales.quantity',
                DB::raw('ROUND((sales.amount / 100), 2) as amount'),
                DB::raw('ROUND((products.sell_price / 100), 2) as sell_price'),
                'sales.sale_date',
            ])
            ->leftJoin('products', 'products.id', '=', 'sales.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->orderBy('sales.id', 'desc')
            ->whereNotNull('sales.deleted_at')
            ->get();


        $grandTotal = Sale::selectRaw('SUM(sales.amount) as total_sales')->first();
        return view('admin.admin-archive-sale', compact('sales', 'grandTotal'));
    }

    public function restore(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        try {
            $this->inventoryReportService->restoreSale($validated['id']);
        } catch (Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
        return redirect()->back();
    }
    public function details($productId)
    {
        $product = Product::where('id', $productId)->first();
        return response()->json($product);
    }
}
