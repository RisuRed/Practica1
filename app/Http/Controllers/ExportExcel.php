<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use Illuminate\Http\Request;
use Excel;

class ExportExcel extends Controller
{
    public function exportEventData(){

        $fileName = 'eventos.xlsx';   

        return Excel::store(new EventExport, $fileName);
      }
}
