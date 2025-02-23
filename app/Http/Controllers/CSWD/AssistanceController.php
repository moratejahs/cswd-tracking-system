<?php

namespace App\Http\Controllers\CSWD;

use App\Http\Controllers\Controller;
use App\Models\AssistanceFund;
use App\Models\Barangay;
use App\Models\BarangayAssitance;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

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
                    return '<a id="editAssitance" href="' . route('admin.assistance.edit', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-list"></i>
                            </a>
                            <a id="mapAssistance" href="' . route('admin.assistance.show', $assistance->id) . '"
                                class="btn btn-warning rounded-pill btn-sm">
                                <i class="bi bi-map"></i>
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
        return view('admin.assistancefund.index');
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
    public function edit(Request $request, string $id)
    {
        $navTitle = AssistanceFund::where('id',$id)->first();
        $barangays = DB::table('barangay_assitances')
            ->leftJoin('barangays', 'barangays.id', '=', 'barangay_assitances.barangay_id')
            ->where('barangay_assitances.assistance_id', $id)
            ->select('barangays.*', 'barangay_assitances.status', 'barangay_assitances.id as barangay_assitances_id')
            ->get();
            // dd($barangays);
        return view('admin.assistancefund.list-barangays', compact( 'navTitle', 'barangays'));
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
    public function update(Request $request, string $id)
    {
        //
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