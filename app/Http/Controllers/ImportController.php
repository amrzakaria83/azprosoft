<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function import()
{
    Excel::import(new YourImport, 'file.xlsx');
}
}



class ImportdrugController extends Controller
{
    // ...

    public function import1()
    {
        Excel::import(new UsersImport, 'users.xlsx');

        return redirect('/')->with('success', 'Users imported successfully.');
    }
}

