<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PembelianExport;
use App\Exports\PenjualanExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportDataController extends Controller 
{
    public function purchase_export_data(Request $request) 
    {
        return Excel::download(new PembelianExport($request), 'purchase_report'.date('_Ymd_His').'.xlsx');
    }
    
    public function sales_export_data(Request $request) 
    {
        // dd($request);
        return Excel::download(new PenjualanExport($request), 'sales_report'.date('_Ymd_His').'.xlsx');
    }
}
