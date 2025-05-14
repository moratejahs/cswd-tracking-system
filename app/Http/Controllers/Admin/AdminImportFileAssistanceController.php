<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\AssistanceImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminImportFileAssistanceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Excel::import(new AssistanceImport(), $request->file("import"));
        return redirect()->back()->with("success", "Assistance imported successfully");
    }
}
