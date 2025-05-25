<?php

namespace App\Http\Controllers;

use App\Models\SubFund;
use App\Models\Barangay;
use App\Models\Category;
use App\Models\Assistance;
use Illuminate\Http\Request;
use App\Models\ClientCategory;
use App\Models\BarangayAssitant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AssitanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $validated = $request->validate([
        //     'start_date' =>'required',
        //     'end_date' =>'required',
        // ]);
        if ($request->ajax()) {
            $query = DB::table('assistances as a')
                ->join(DB::raw('
                    (SELECT MIN(id) as id
                    FROM assistances
                    GROUP BY first_name, middle_name, last_name) as grouped
                '), 'a.id', '=', 'grouped.id')
                ->select('a.*');

            // Apply date range filter only if both dates are provided
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->where(function($q) use ($request) {
                    $q->whereBetween('a.created_at', [$request->start_date, $request->end_date])
                      ->orWhere('a.created_at', $request->start_date)
                      ->orWhere('a.created_at', $request->end_date);
                });
            }
            return DataTables::of($query)
                ->addColumn('action', function ($assistance) {
                    return '
                     <a id="editAssitance" href="' . route('sub-fund.history', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-info-circle"></i>
                            </a>
                    <a id="addSubfund" href="javascript:void(0)" data-url="' . route('admin.service.show', $assistance->id) . '"
                                class="btn btn-success rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Add Subfund">
                                <i class="bi bi-plus-circle"></i>
                            </a>
                            <a id="edit-user" href="javascript:void(0)" data-url="' . route('admin.service.edit', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="removeService" href="javascript:void(0)" data-user-id="' . $assistance->id . '"
                                data-url="' . route('admin.service.show', $assistance->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Product">
                                <i class="bi bi-trash"></i>
                            </a>
                           ';
                })
                ->rawColumns(['action'])

                ->make(true);
        }



        return view('admin.assistance.index', [
            'getcategories' => ClientCategory::all(),

        ]);
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
           'start_date' => 'required',
          'end_date' => 'required',
        ]);
        // dd($validated);
        $assitance = Assistance::whereBetween('created_at', [$validated['start_date'], $validated['end_date']])->get();
        // dd($assitance);

       return redirect()->back();
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
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'birth_date' => 'required',
                'age' => 'required',
                'gender' => 'required',
                'occupation' => 'required',
                'contact_no' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'outlet_name' => 'nullable',
                'outlet_address' => 'required',
                'purpose' => 'required',
                'category_name' => 'required',
                'amount' => 'required',
                'responsible_person' => 'required',
            ]);

            // Check if beneficiary with same name already exists
            $existingBeneficiary = Assistance::where('first_name', $validated['first_name'])
                ->where('middle_name', $validated['middle_name'])
                ->where('last_name', $validated['last_name'])
                ->first();

            if ($existingBeneficiary) {
                return back()->withErrors([
                    'duplicate' => 'A beneficiary with this name already exists in the system.'
                ])->withInput();
            }

            // Logging validated data for debugging
            Log::info('Validated Data:', $validated);

            DB::beginTransaction();

            try {
                BarangayAssitant::create([
                    'outlet_name' => $validated['outlet_name'],
                    'outlet_address' => $validated['outlet_address'],
                    'lat' => $validated['latitude'],
                    'long' => $validated['longitude'],
                ]);

                Assistance::create([
                    'first_name' => $validated['first_name'],
                    'middle_name' => $validated['middle_name'],
                    'last_name' => $validated['last_name'],
                    'birth_date' => $validated['birth_date'],
                    'age' => $validated['age'],
                    'gender' => $validated['gender'],
                    'contact_no' => $validated['contact_no'],
                    'occupation' => $validated['occupation'],
                    'lat' => $validated['latitude'],
                    'long' => $validated['longitude'],
                    'outlet_name' => $validated['outlet_name'],
                    'address' => $validated['outlet_address'],
                    'purpose' => $validated['purpose'],
                    'category' => $validated['category_name'],
                    'amount' => $validated['amount'],
                    'responsible_person' => $validated['responsible_person'],
                ]);

                DB::commit();

                return to_route('admin.service.index')
                    ->with('message', 'Beneficiary created successfully');
            } catch (\Exception $e) {
                DB::rollback();

                // Log the exception for further debugging
                Log::error('Error creating beneficiary:', ['error' => $e->getMessage()]);

                throw $e;
            }
        } catch (\Exception $e) {
            // Log general error and show message
            Log::error('An error occurred while saving the beneficiary:', ['error' => $e->getMessage()]);
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

    public function history($id){

        $histories = SubFund::query()
        ->with(['assistance', 'category'])
        ->where('assistance_id', $id)
        ->get();
        $assitance = Assistance::findOrFail($id);
        return view('admin.assistance.assistance-info', [
            'histories' => $histories,
            'assitance' => $assitance,
        ]);
    }
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

    public function getAssistanceData($id)
    {
        $assistances = Assistance::select('first_name', 'last_name', DB::raw('COUNT(*) as total_visited'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('first_name', 'last_name')
            ->where('id', $id)
            ->get();

        return response()->json($assistances);
    }
}
