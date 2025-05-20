<?php

namespace App\Http\Controllers\CSWD;

use App\Models\SubFund;
use App\Models\Assistance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
           'assistance_id' => 'required',
           'category_id' => 'required',
           'purpose' => 'required',
           'amount' => 'required',
        ]);
        SubFund::create([
            'assistance_id' => $validated['assistance_id'],
            'category_id'=> $validated['category_id'],
            'purpose'=> $validated['purpose'],
            'amount'=> $validated['amount'],
            'personal_reponsible' => auth()->user()->first_name,
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Assistance::findOrFail($id);
        return response()->json([
            'data' => $data
        ]);
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
