<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Validator;

class UsersController extends Controller
{

    public function show($id)
    {
        $data = User::find($id);
        return view('client.user.show', compact('data'));
    }
}
