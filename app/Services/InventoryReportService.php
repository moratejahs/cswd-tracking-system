<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InventoryReportService
{
    public function storeInventoryProduct($code, $productName, $supplierName, $quantity, $unit, $sellPrice, $costPriceTwo, $costPrice, $categoryId)
    {
        $existingProduct = Product::where('product_name', $productName)->first();
        if ($existingProduct) {
            dd($existingProduct);
            Session::flash('warning', 'This product has already been added, Please try another.');
        }
        $sequentialNumber = 1;

        do {
            $code = str_pad($sequentialNumber, 6, '0', STR_PAD_LEFT);
            $existingRecord = Product::where('code', $code)->first();
            if ($existingRecord) {
                $sequentialNumber++;
            }
        } while ($existingRecord);

        Product::create([
            'code' => $code,
            'product_name' => $productName,
            'supplier_name' => $supplierName,
            'quantity' => $quantity,
            'unit' => $unit,
            'sell_price' => $sellPrice,
            'sell_price_two' => $costPriceTwo,
            'cost_price' => $costPrice,
            'category_id' => $categoryId,
        ]);

    }
    public function storeInventoryCategory($categoryName)
    {
        $category = Category::firstOrCreate(['category_name' => $categoryName]);
        if ($category->wasRecentlyCreated) {
            Session::flash('message', 'Saved successfully.');
        } else {
            Session::flash('warning', 'This category is already exists.');
        }
    }
    public function storeSales($productId, $quantity, $amount, $saleDate, $userId)
    {
        Sale::create([
            'product_id' => $productId,
            'quantity' => $quantity,
            'amount' => $amount,
            'sale_date' => $saleDate,
            'user_id' => $userId,
        ]);
        Session::flash('message', 'Save successfully');
    }
    public function storeInventoryProductStockIn($productId, $remainingQuantity, $newQuantity)
    {
        $productRecord = Product::where('id', $productId)->first();
        $remainingQuantity = $productRecord->quantity;
        $productRecord->update([
            'quantity' => ($remainingQuantity + $newQuantity)
        ]);
        Session::flash('message', 'Add new stock successfully');
    }
    public function editInventoryProductStockIn($productId, $quantity)
    {
        $productRecord = Product::where('id', $productId)->first();
        $productRecord->update([
            'quantity' => $quantity
        ]);
        Session::flash('message', 'Save changes successfully');
    }


    public function getInventoryByCategory($categoryId)
    {
        //
    }

    public function getInventoryByProduct($productId)
    {
        return DB::table('products as pro')
            ->select(
                'pro.id as product_id',
                'pro.code as product_code',
                'pro.product_name',
                'pro.supplier_name',
                'cat.id as category_id',
                'pro.unit',
                DB::raw('(pro.quantity) as quantity'),
                DB::raw('ROUND((pro.cost_price / 100), 2) as cost_price'),
                DB::raw('ROUND((pro.sell_price / 100), 2) as sell_price'),
                DB::raw('ROUND((pro.sell_price_two / 100), 2) as sell_price_two'),
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
            ->whereNull('pro.deleted_at')
            ->groupBy('pro.code', 'pro.id', 'pro.product_name', 'cat.category_name', 'pro.unit', 'pro.cost_price', 'pro.sell_price', 'pro.quantity')
            ->where('pro.id', $productId)
            ->first();
    }
    public function getSale($saleId)
    {
        return DB::table('products AS pro')
            ->leftJoin('categories AS cat', 'pro.category_id', '=', 'cat.id')
            ->leftJoin('sales AS sales', 'sales.product_id', '=', 'pro.id')
            ->select(
                'pro.id AS product_id',
                'sales.id as sales_id',
                'sales.quantity as sales_quantity',
                'sales.amount as sales_amount'
            )
            ->where('sales.id', $saleId)
            ->first();
    }

    public function updateInventoryProduct($id, $productName, $quantity, $unit, $sellPrice, $sellPriceTwo, $costPrice)
    {
        $productRecord = Product::where('id', $id)->first();
        $productRecord->update([
            'product_name' => $productName,
            'quantity' => $quantity,
            'unit' => $unit,
            'sell_price' => $sellPrice,
            'sell_price_two' => $sellPriceTwo,
            'cost_price' => $costPrice,
        ]);
        Session::flash('message', 'Saved changes successfully.');
    }
    public function updateSales($saleId, $productId, $qty, $amount)
    {
        $sale = Sale::where('id', $saleId)->first();
        $sale->update([
            'product_id' => $productId,
            'quantity' => $qty,
            'amount' => $amount
        ]);
        Session::flash('message', 'Saved changes successfully.');
    }

    public function destroyProduct($productId)
    {
        $productRecord = Product::where('id', $productId)->first();
        $productRecord->delete();
        Session::flash('message', 'Deleted successfully.');
    }
    public function destroySale($saleId)
    {
        $sale = Sale::where('id', $saleId)->first();
        $sale->delete();
        Session::flash('message', 'Deleted successfully.');
    }
    public function restoreProduct($productId)
    {
        $productRecord = Product::withTrashed()->where('id', $productId)->first();
        $productRecord->restore();
        Session::flash('message', 'Restored successfully.');
    }
    public function restoreSale($saleId)
    {
        $productRecord = Sale::withTrashed()->where('id', $saleId)->first();
        $productRecord->restore();
        Session::flash('message', 'Restored successfully.');
    }
}
