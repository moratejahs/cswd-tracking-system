<?php

namespace App\Http\Controllers\CSWD;

use Illuminate\Http\Request;
use App\Models\ClientCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
class ClientCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request  $request)
    {
        if ($request->ajax()) {
            $data = ClientCategory::all();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '
                            <a id="editCategory" href="javascript:void(0)" data-user-id="' . $data->id . '"
                                data-url="' . route('admin.client-category.show', $data->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Update Category">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="removeCategory" href="javascript:void(0)" data-user-id="' . $data->id . '"
                                data-url="' . route('admin.client-category.show', $data->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete account">
                                <i class="bi bi-trash"></i>
                            </a>
                            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.client-category.index');
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
            // 'code' => 'required|string',
            'description' => 'required|string',
        ]);
        ClientCategory::create([
            // 'code' => $validated['code'],
            'description' => $validated['description'],
        ]);
        return redirect()->back()->with('message', 'Client category added successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ClientCategory::find($id);
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
            // 'code' => 'required|string',
            'id' => 'required',
            'description' => 'required|string',
        ]);
        $clientCategory = ClientCategory::find($validated['id']);
        $clientCategory->update([
            'description' => $validated['description'],
        ]);
        return redirect()->back()->with('message', 'Client category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            // 'code' => 'required|string',
            'id' => 'required',
        ]);
        $clientCategory = ClientCategory::find($validated['id']);
        $clientCategory->delete();
        return redirect()->back()->with('message', 'Client category deleted successfully.');
    }
}