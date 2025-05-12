<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Category;
use App\Models\Assistance;
use Illuminate\Http\Request;
use App\Models\ClientCategory;
use App\Models\BarangayAssitant;
use Yajra\DataTables\Facades\DataTables;

class AssitanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Assistance::all();
            return DataTables::of($data)
                ->addColumn('action', function ($assistance) {
                    return '<a id="edit-user" href="' . route('admin.service.edit', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="removeService" href="javascript:void(0)" data-user-id="' . $assistance->id . '"
                                data-url="' . route('admin.service.show', $assistance->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Product">
                                <i class="bi bi-trash"></i>
                            </a>';
                })
                ->rawColumns(['action'])
                ->addColumn('full_name', function ($assistance) {
                    return trim("{$assistance->first_name} {$assistance->middle_name} {$assistance->last_name}");
                })
                ->make(true);
        }
        $getcategories = ClientCategory::all();
        return view('admin.assistance.index', [
           'getcategories' => $getcategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientCategories = ClientCategory::all();
        $barangays = Barangay::all();
        return view('admin.assistance.create', [
            'clientCategories' => $clientCategories,
            'barangays' => $barangays
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required',
        'middle_name' => 'required',
        'last_name' => 'required',
        'birth_date' => 'required|date',
        'address' => 'required',
        'contact_no' => 'required',
        'status' => 'required',
        'occupation' => 'required',
        'assistance' => 'required',
        'quantity' => 'required|integer',
        'person_of_responsible' => 'required',
        'latitude'=> 'required',
        'longitude'=>'required',
        'outlet_name'=> 'required',
        'outlet_address'=> 'required',
    ]);
    dd($validated);
    // Check if the combination already exists
    $exists = Assistance::where('first_name', $validated['first_name'])
        ->where('middle_name', $validated['middle_name'])
        ->where('last_name', $validated['last_name'])
        ->exists();

    if ($exists) {
        return back()->withErrors(['duplicate' => 'A beneficiary with the same name already exists.'])->withInput();
    }

    // Store the record
    $assistant = Assistance::create([
        'first_name' => $validated['first_name'],
        'middle_name' => $validated['middle_name'],
        'last_name' => $validated['last_name'],
        'birth_date' => $validated['birth_date'],
        'address' => $validated['address'],
        'contact_no' => $validated['contact_no'],
        'status' => $validated['status'],
        'occupation' => $validated['occupation'],
        'assistance' => $validated['assistance'],
        'quantity' => $validated['quantity'],
        'person_of_responsible' => $validated['person_of_responsible'],
        'user_id' => auth()->id(),
    ]);

    BarangayAssitant::create([
        'assistance_id' => $assistant->id,
        'outlet_name' => $validated['outlet_name'],
        'outlet_address' => $validated['outlet_address'],
        'latitude' => $validated['latitude'],
        'longtitude' => $validated['longitude'],
    ]);

    return to_route('admin.service.index')
        ->with('message', 'Beneficiary created successfully');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assistance = Assistance::where('id', $id)->first();
        return response()->json($assistance);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assistance = Assistance::where('id', $id)->first();
        $clientCategories = ClientCategory::all();
        $barangays = Barangay::all();
        return view('admin.assistance.edit', [
            'assistance' => $assistance,
            'clientCategories' => $clientCategories,
            'barangays' => $barangays
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'address' => 'required',
            'contact_no' => 'required',
            'status' => 'required',
            'occupation' => 'required',
            'assistance' => 'required',
            'quantity' => 'required|integer',
            'person_of_responsible' => 'required',
        ]);

        $assistance = Assistance::findOrFail($validated['id']);
        $assistance->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'birth_date' => $validated['birth_date'],
            'address' => $validated['address'],
            'contact_no' => $validated['contact_no'],
            'status' => $validated['status'],
            'occupation' => $validated['occupation'],
            'assistance' => $validated['assistance'],
            'quantity' => $validated['quantity'],
            'person_of_responsible' => $validated['person_of_responsible'],
        ]);

        return to_route('admin.service.index')
            ->with('message', 'Beneficiary updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $redirectUrl = route('admin.assistance.index');
        $validated = $request->validate([
            'id' => 'required'
        ]);
        $delete = Assistance::findOrFail($validated['id']);
        $delete->delete();
        return redirect()->back()->with('message', 'Beneficiary deleted successfully');
    }
}
