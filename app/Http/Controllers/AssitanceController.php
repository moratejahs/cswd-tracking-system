<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

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
                    return '<a id="edit-user" href="' . route('admin.assistance.edit', $assistance->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="removeAssistance" href="javascript:void(0)" data-user-id="' . $assistance->id . '"
                                data-url="' . route('admin.assistance.show', $assistance->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Product">
                                <i class="bi bi-trash"></i>
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.assistance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.assistance.create');
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
        ]);
        Assistance::create([
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

        return to_route('admin.assistance.index')
            ->with('message', 'Assistance created successfully');
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

        return view('admin.assistance.edit', ['assistance' => $assistance]);
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

        return to_route('admin.assistance.index')->with('message', 'Assistance updated successfully');
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
        return redirect()->back()->with('message', 'Assistance deleted successfully');
    }
}