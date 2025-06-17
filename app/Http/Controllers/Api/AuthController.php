<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Str;
use DataTables;
use Validator;

class AuthController extends Controller
{

    // #################   Student App   ####################

    public function profile($id)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        try {

            $data = Employee::find($id);
            // $results = StudentResource::collection($data)->response()->getData(true);
            $results = new EmployeeResource($data);
            
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);

        } catch (\Throwable $th) {
            return response(['status' => 401, 'msg' => trans('lang.error'), 'data' => NULL]);
        }
        
        return response(['status' => 401, 'msg' => trans('lang.error'), 'data' => NULL]);
    }

    public function login(Request $request)
    {

        $rule = [
            'username' => 'required',
            'password' => 'required|min:6',
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {
            $client = Employee::where('phone', $request->username)->first();

            if (!empty($client)) {

                $client->token = Str::random(60);
                $client->save();

                if (Hash::check($request->password, $client->password)) {

                    if ($client->is_active != 1) {
                        return response(['status' => 401, 'msg' => trans('auth.error_is_active'), 'data' => NULL]);
                    }

                    Auth::attempt(['phone' => $request->username, 'password' => $request->password, 'is_active' => $client->is_active]);

                    $results = new EmployeeResource($client);
                    
                    return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);

                } else {
                    return response(['status' => 401, 'msg' => trans('auth.error_password'), 'data' => NULL]);

                }
            } else {
                return response(['status' => 401, 'msg' => trans('lang.error'), 'data' => NULL]);

            }

        }

    }

    public function register(Request $request)
    {

        $rule = [
            'name' => 'required|string|max:255',
            'job_title' => 'nullable',
            'national_id' => 'required|unique:employees',
            'phone' => 'required|unique:employees',
            'password' => 'required|min:8',
            'email' => 'required|unique:employees',
            'address' => 'required',
            'birth_date' => 'required',
            'work_date' => 'required',
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {
            $user = Employee::where('phone', $request->phone)->first();
            if ($user) {
                return response(['status' => 401, 'msg' => trans('auth.error_exist'), 'data' => NULL]); 
            }

            $row = Employee::create([
                'name_en' => $request->name,
                'job_title' => $request->job_title,
                'national_id' => $request->national_id,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'work_date' => $request->work_date,
                'is_active' => '0',
                'type' => '0',
                'gender' => '0',
                'method_for_payment' => '0',
            ]);

            $results = new EmployeeResource($row);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $results]);

        }

    }
    
    public function updateFcToken(Request $request)
    {

        $rule = [
            'user_id' => 'required',
            'token' => 'required',
        ];
        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {
            $user = Employee::find($request->user_id);
            if (!$user) {
                return response(['status' => 401, 'msg' => trans('auth.not_login'), 'data' => NULL]); 
            }

            $data = Employee::where('id', $request->user_id )->update([
                'fc_token'=> $request->token
            ]);
                    
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => $data]);

        }

    }

    public function deleteaccount($id)
    {

        $token = request()->header('token');
        $user = $this->check_api_token($token);
        if (!$user) {
            return response(['status' => 403, 'msg' => trans('auth.not_login'), 'data' => NULL]);
        }

        try {

            Employee::where('id', $id)->forceDelete();
            
            return response(['status' => 200, 'msg' => trans('lang.successful'), 'data' => NULL]);

        } catch (\Throwable $th) {
            return response(['status' => 401, 'msg' => trans('lang.error'), 'data' => NULL]);
        }
        
        return response(['status' => 401, 'msg' => trans('lang.error'), 'data' => NULL]);
    }

}
