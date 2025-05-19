<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\AssistanceImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
 // this one has the XLSX constant

class AdminImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
        Excel::import(new AssistanceImport(), $request->file('import'));

        return redirect()->back()->with('message', 'Data Imported Successfully');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();

        return redirect()->back()->withErrors(['import' => 'Validation failed in some rows. Check your data.']);
    } catch (\Throwable $e) {
        // General error (e.g., from your `findBarangayData` logic)
        \Log::error('Import error: ' . $e->getMessage());

        return redirect()->back()->withErrors(['import' => 'Import failed: ' . $e->getMessage()]);
    }
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
