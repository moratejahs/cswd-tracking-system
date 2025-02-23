<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ManageAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request  $request)
    {

        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addColumn('action', function ($user) {
                    return '
                            <a id="editAccount" href="javascript:void(0)" data-user-id="' . $user->id . '"
                                data-url="' . route('admin.manage_account.show', $user->id) . '"
                                class="btn btn-light-secondary rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Update account">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a id="removeAccount" href="javascript:void(0)" data-user-id="' . $user->id . '"
                                data-url="' . route('admin.manage_account.show', $user->id) . '"
                                class="btn btn-danger rounded-pill btn-sm" data-toggle="tooltip" data-placement="top" title="Delete account">
                                <i class="bi bi-trash"></i>
                            </a>
                            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.manage-account.index');
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
        $valited = $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ]);
        if (User::where('username', $request->username)->exists()) {
            return response()->json(['message' => 'Username already exists'], 400);
        }

        User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('message', 'Account created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->first();


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('id', $id)->first();
        return response()->json($user);
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
            'position' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'nullable',
        ]);

        $user = User::findOrFail($validated['id']);

        if (User::where('username', $request->username)->where('id', '!=', $validated['id'])->exists()) {
            return response()->json(['message' => 'Username already exists'], 400);
        }

        $user->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated[']middle_name'],
            'last_name' => $validated['last_name'],
            'position' => $validated['position'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        return redirect()->back()->with('message', 'Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required'
        ]);
        $user = User::findOrFail($validated['id']);
        $user->delete();
        return redirect()->back()->with('message', 'Account deleted successfully');
    }
}