<?php

namespace App\Http\Controllers\CSWD;

use App\Models\Assistance;
use App\Models\Barangay;
use App\Models\SubFund;
use Illuminate\Http\Request;
use App\Models\AssistanceFund;
use App\Models\ClientCategory;
use App\Models\BarangayAssitance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = AssistanceFund::all();
            return DataTables::of($data)
                ->addColumn('action', function ($assistance) {
                    return '
                     <a id="editAssitance" href="' . route('sub-fund.history', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        <a id="editAssitance" href="' . route('sub-fund.history', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-info-circle"></i>
                            </a>
                    <a id="editAssitanceEDIT" href="' . route('admin.assistance.edit', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-list"></i>
                            </a>
                            <a id="mapAssistance" href="' . route('admin.assistance.show', $assistance->id) . '"
                                class="btn btn-warning rounded-pill btn-sm">
                                <i class="bi bi-map"></i>
                            </a>
                            <a id="subAssistance" href="javascript:void(0)" data-user-id="' . $assistance->id . '"
                                data-url="' . route('sub-fund.show', $assistance->id) . '"
                                class="btn btn-info rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Sub Assistance">
                                <i class="bi bi-diagram-3"></i>
                            </a>
                            <a id="deleteAssistanceFund" href="javascript:void(0)" data-user-id="' . $assistance->id . '"
                                data-url="' . route('admin.assistance.getAssistantId', $assistance->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Assistant">
                                <i class="bi bi-trash"></i>
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $categories = ClientCategory::all();
        return view('admin.assistancefund.index',[
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangays = Barangay::all();
        return view('admin.assistancefund.includes.create',[
            'barangays' => $barangays
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'code' => 'required|string',
            'assistance_name' => 'required|string',
            'description' => 'required|string',
            'barangaysid' => 'required|array', // Ensure it's an array// Ensure each barangay ID exists in the barangays table
        ]);
        // dd($request->all());
        // Create AssistanceFund record
        $assistance = AssistanceFund::create([
            'user_id' => auth()->id(), // Assuming the logged-in user creates the assistance
            'code' => $validated['code'],
            'assistance_name' => $validated['assistance_name'],
            'description' => $validated['description'],
        ]);
        // dd($validated['barangaysid']);

        // Store the relationship in BarangayAssitance
        foreach ($validated['barangaysid'] as $barangayId) {
            BarangayAssitance::create([
                'barangay_id' =>  $barangayId, // Convert to integer
                'assistance_id' =>  $assistance->id,
            ]);
        }

        return to_route('admin.assistance.index')
        ->with('message', 'Assistance created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barangays = DB::table('barangay_assitances')
            ->leftJoin('barangays', 'barangays.id', '=', 'barangay_assitances.barangay_id')
            ->where('barangay_assitances.assistance_id', $id)
            ->select('barangays.*', 'barangay_assitances.status')
            ->get();
        return view('admin.assistancefund.show-map', compact('barangays'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $navTitle = AssistanceFund::where('id',$id)->first();

        $assistance = Assistance::find($id);
            // dd($barangays);
        return view('admin.assistance.edit', compact( 'navTitle', 'assistance'));
    }

    public function getBarangayId(string $id){
        $barangay = BarangayAssitance::find($id);
        return response()->json($barangay);
    }
    public function getAssistantId(string $id){
        $assistant = AssistanceFund::find($id);
        return response()->json($assistant);
    }

    public function approvedBarangay(Request $request){
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $approved = BarangayAssitance::find($validated['id']);
        // dd($approved);
        $approved->update([
            'status' => 'done'
        ]);
        return redirect()->back()->with('message', 'Barangay approved successfully');

    }

    public function disApprovedBarangay(Request $request){
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $approved = BarangayAssitance::find($validated['barangay_id']);
        dd($approved);
        $approved->update([
            'status' => 'failed'
        ]);

        return to_route('admin.assistance.edit')
        ->with('message', 'Barangay approved successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'code' => 'required|string',
            'id' => 'required',
            'assistance_name' => 'required|string',
            'description' => 'required|string',
            'barangaysid' => 'required|array',
        ]);

        // Find the AssistanceFund record
        $assistance = AssistanceFund::findOrFail($validated['id']);

        // Update AssistanceFund fields
        $assistance->update([
            'code' => $validated['code'],
            'assistance_name' => $validated['assistance_name'],
            'description' => $validated['description'],
        ]);

        // Remove existing barangay relationships
        BarangayAssitance::where('assistance_id', $assistance->id)->delete();

        // Store the new relationships in BarangayAssitance
        foreach ($validated['barangaysid'] as $barangayId) {
            BarangayAssitance::create([
                'barangay_id' => $barangayId,
                'assistance_id' => $assistance->id,
            ]);
        }

        return to_route('admin.assistance.index')
            ->with('message', 'Assistance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        /// Find the assistance record
        $assistance = AssistanceFund::findOrFail($validated['id']);

        // Delete related BarangayAssistance records
        BarangayAssitance::where('assistance_id', $assistance->id)->delete();

        // Delete the AssistanceFund record
        $assistance->delete();

        return redirect()->back()->with('message', 'Assistance deleted successfully');
    }
}
