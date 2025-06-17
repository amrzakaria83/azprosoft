<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Models\Role;
use App\Models\Employee;

use Helper;
use Illuminate\Routing\Controller as BaseController;





class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



}


