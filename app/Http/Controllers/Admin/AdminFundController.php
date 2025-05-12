<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminFundController extends Controller
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
        $validated = $request->validate([
            'assitance_id' => 'required',
            'category_id' => 'required',
            'purpose' => 'required',
            'amount' => 'required',
            'responsible_person' => 'required',
        ]);
        $fund = Fund::create([
            'purpose' => $validated['purpose'],
            'amount' => $validated['amount'],
            'responsible_person' => $validated['responsible_person'],
            'assistance_id' => $validated['assistance_id'],
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->back()->with('message', 'Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Fund::findOrFail($id);
        return response()->json($data);
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
            'fund_id' => 'required',
            'assitance_id' => 'required',
            'category_id' => 'required',
            'purpose' => 'required',
            'amount' => 'required',
            'responsible_person' => 'required',
        ]);
        $fund = Fund::findOrFail($validated['fund_id']);
        $fund->update([
            'purpose' => $validated['purpose'],
            'amount' => $validated['amount'],
            'responsible_person' => $validated['responsible_person'],
            'assistance_id' => $validated['assistance_id'],
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->back()->with('message', 'Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
         $validated = $request->validate([
            'fund_id' => 'required',

        ]);
        $fund = Fund::findOrFail($validated['fund_id']);
        $fund->delete();
          return redirect()->back()->with('message', 'Deleted successfully');
    }
}
