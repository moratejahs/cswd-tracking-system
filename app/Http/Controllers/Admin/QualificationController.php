<?php

namespace App\Http\Controllers\Admin;

use App\Models\Qualification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Qualification::all();
            return DataTables::of($data)
                ->addColumn('action', function ($qualification) {
                    return '
                             <a id="editQualification" href="javascript:void(0)" data-user-id="' . $qualification->id . '"
                                data-url="' . route('qualification.show', $qualification->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Qualification">
                                 <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="deleteQualification" href="javascript:void(0)" data-user-id="' . $qualification->id . '"
                                data-url="' . route('qualification.show', $qualification->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Qualification">
                                <i class="bi bi-trash"></i>
                            </a>'
                            ;
                })
                // Enable HTML rendering
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.qualification.index');
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
            'name' => 'required',
            'desc' => 'required',
        ]);
        $create = Qualification::create([
            'name' => $validated['name'],
            'description' => $validated['desc'],
        ]);
        return redirect()->back()->with('message', 'Qualification addded succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Qualification::where('id',$id)->first();
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
            'id' => 'required',
            'name' => 'required',
            'desc' => 'required',
        ]);
        $qualification = Qualification::find($validated['id']);
        $qualification->update([
            'name' => $validated['name'],
            'description' => $validated['desc'],
        ]);
        return redirect()->back()->with('message', 'Qualification updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $qualification = Qualification::find($validated['id']);
        $qualification->delete();
        return redirect()->back()->with('message', 'Qualification deleted succesfully');
    }
}