<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Category;
use App\Models\Assistance;
use Illuminate\Http\Request;
use App\Models\ClientCategory;
use App\Models\BarangayAssitant;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AssitanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Assistance::query()
            ->with(['barangays'])
            ->get();
            return DataTables::of($data)
                ->addColumn('full_name', function ($assistance) {
                    return trim("{$assistance->first_name} {$assistance->middle_name} {$assistance->last_name}");
                })
                ->editColumn('barangay_name', function ($assistance) {
                    return $assistance->barangays->outlet_address ?? '';
                })
                ->editColumn('birth_date', function ($assistance) {
                    return $assistance->birth_date ? date('F d, Y', strtotime($assistance->birth_date)) : '';
                })
                 ->editColumn('contact_no', function ($assistance) {
                    return $assistance->contact_no ?? '';
                })
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

                ->make(true);
        }

        return view('admin.assistance.index', [
            'getcategories' => ClientCategory::all(),
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
        try {
            $validated = $request->validate([
                'first_name' => 'required',
                'middle_name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'age' => 'required|integer',
                'gender' => 'required',
                'occupation' => 'required',
                'contact_no' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'outlet_name' => 'required',
                'outlet_address' => 'required',
            ]);
            // dd($validated);
            // Check if the combination already exists
            $exists = Assistance::where('first_name', $validated['first_name'])
                ->where('middle_name', $validated['middle_name'])
                ->where('last_name', $validated['last_name'])
                ->exists();

            if ($exists) {
                return back()->withErrors(['duplicate' => 'A beneficiary with the same name already exists.'])->withInput();
            }

            DB::beginTransaction();
            try {

                $barnagays = BarangayAssitant::create([
                    'outlet_name' => $validated['outlet_name'],
                    'outlet_address' => $validated['outlet_address'],
                    'lat' => $validated['latitude'],
                    'long' => $validated['longitude'],
                ]);
                // dd($barnagays);
                // // Store the record
                // dd($barnagays->id);
                Assistance::create([
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'],
                    'last_name' => $validated['last_name'],
                    'birth_date' => $validated['birth_date'],
                    'age' => $validated['age'],
                    'gender' => $validated['gender'],
                    'contact_no' => $validated['contact_no'],
                    'occupation' => $validated['occupation'],
                    'barangay_id' => $barnagays->id,
                ]);
               //  dd($assistant);


                DB::commit();
                return to_route('admin.service.index')
                    ->with('message', 'Beneficiary created successfully');

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while saving the beneficiary. Please try again.'])->withInput();
        }
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
            // 'id' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'occupation' => 'required',
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
