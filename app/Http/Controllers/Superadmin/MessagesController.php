<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Employee;
use App\Models\Message;
use App\Models\MessagesResponse;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Auth;

class MessagesController extends Controller
{
    protected $viewPath = 'superadmin.message';
    private $route = 'superadmin.messages';

    public function __construct(Message $model)
    {
        $this->objectModel = $model;
    }
    public function index(Request $request)
    {
        $data = $this->objectModel::get();
        
        if ($request->ajax()) {
            $data = $this->objectModel::where('sender_type', 0)->where('sender_id', auth('superadmin')->user()->id);
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function ($row) {
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
                    </div>';
                    return $checkbox;
                })
                ->addColumn('name', function ($row) {
                    $names  = [];

                    // Assuming $row['receiver_id'] is a JSON-encoded string
                    $receiverIds = json_decode($row['receiver_id'], true);
                    if (is_array($receiverIds)) {
                        foreach ($receiverIds as $receiverId) {
                            $receiverId = str_replace('"', '', $receiverId);
                            $receiverId = intval($receiverId);
                            $receiver = Employee::find($receiverId);
                            if ($receiver) {
                                $names[] = '<div class="d-flex flex-column " style="border: dashed;">
                                    <apan href="javascript:;" class="text-gray-800 text-hover-primary mb-1 text-center text-danger">' . $receiver->name_en . '</apan>
                               
                                    <apan href="javascript:;" class="text-gray-800 text-hover-primary mb-1 text-center">' . $receiver->name_ar . '</apan>
                                </div>';
                            }
                        }
                    }
    
                    return implode('', $names);
                })
                
                ->addColumn('email', function ($row) {
                    $email = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">' . $row->created_at . '</a></div>';
                    return $email;
                })
                ->addColumn('status', function ($row) {
                    $status = '<div class="badge badge-light-';
                    $status .= $row->status === 'read' ? 'success' : 'danger';
                    $status .= ' fw-bold">' . ($row->status === 'read' ? 'تم المشاهدة' : 'لم يتم المشاهدة') . '</div>';
                    return $status;
                })
                ->addColumn('actions', function ($row) {
                    $actions = '<div class="ms-2">
                        <a href="'.route($this->route.'.response', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="bi bi-envelope-at-fill fs-1x"></i>
                        </a>
                    </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == 'read' || $request->get('status') == 'unread') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name', 'email', 'status', 'checkbox', 'actions'])
                ->make(true);
        }
        return view($this->viewPath . '.index');
    }

    // public function index(Request $request)
    // {
    //     $data = $this->objectModel::get();

    //     if ($request->ajax()) {
    //         $data = $this->objectModel::where('sender_type', 0)->where('sender_id', auth('superadmin')->user()->id);
    //         $data = $data->orderBy('id', 'DESC');

    //         return Datatables::of($data)
    //             ->addColumn('checkbox', function($row){
    //                 $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
    //                                 <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
    //                             </div>';
    //                 return $checkbox;
    //             })
    //             ->addColumn('name', function($row){

    //                 $names = [];
    //                 foreach ($row['receiver_id'] as $receiver) {
    //                     $names[] = '<div class="d-flex flex-column">
    //                         <a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">' . $receiver->getemprecive->name_en . '</a>
    //                     </div>
    //                     <div class="d-flex flex-column">
    //                         <a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">' . $receiver->getemprecive->name_ar . '</a>
    //                     </div>';
    //                 }
    //                 return implode('', $names);
    //             })

    //             ->addColumn('email', function($row){
    //                 $email = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->created_at.'</a></div>';
    //                 return $email;
    //             })
    //             ->addColumn('status', function($row){
    //                 if($row->status == 'read') {
    //                     $status = '<div class="badge badge-light-success fw-bold">تم المشاهدة</div>';
    //                 } else {
    //                     $status = '<div class="badge badge-light-danger fw-bold">لم يتم المشاهدة</div>';
    //                 }

    //                 return $status;
    //             })
    //             ->addColumn('actions', function($row){
    //                 $actions = '<div class="ms-2">
    //                             <a href="'.route($this->route.'.response', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    //                                 <i class="bi bi-envelope-at-fill fs-1x"></i>
    //                             </a>
    //                         </div>';
    //                 return $actions;
    //             })
    //             ->filter(function ($instance) use ($request) {
    //                 if ($request->get('status') == 'read' || $request->get('status') == 'unread') {
    //                     $instance->where('status', $request->get('status'));
    //                 }
    //                 if (!empty($request->get('search'))) {
    //                         $instance->where(function($w) use($request){
    //                         $search = $request->get('search');
    //                         $w->orWhere('name','LIKE', "%$search%")
    //                         ->orWhere('phone','LIKE', "%$search%");
    //                     });
    //                 }
    //             })
    //             ->rawColumns(['name', 'email','status','checkbox','actions'])
    //             ->make(true);
    //     }
    //     return view($this->viewPath .'.index');
    // }

    public function inbox(Request $request)
    {
        $data = $this->objectModel::get();
        $codemp = Auth::guard('superadmin')->user()->id;
        if ($request->ajax()) {
            $data = $this->objectModel::whereJsonContains('receiver_id', "$codemp");
            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $name = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1 text-danger">'.$row->getemp->name_en.'</a></div>';
                    $name .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp->name_ar.'</a></div>';                    return $name;
                })
                ->addColumn('email', function($row){
                    $email = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->created_at.'</a></div>';
                    return $email;
                })
                ->addColumn('status', function($row){
                    if($row->status == 'read') {
                        $status = '<div class="badge badge-light-success fw-bold">تم المشاهدة</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">لم يتم المشاهدة</div>';
                    }

                    return $status;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route($this->route.'.response', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-envelope-at-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == 'read' || $request->get('status') == 'unread') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name','LIKE', "%$search%")
                            ->orWhere('phone','LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name', 'email','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.inbox');
    }
    public function reportcc(Request $request)
    {
        $data = $this->objectModel::get();
        $codemp = Auth::guard('superadmin')->user()->id;

        if ($request->ajax()) {
            // $data = $this->objectModel::where('sender_type', 0)->where('sender_id', auth('superadmin')->user()->id);
            $data = $this->objectModel::whereJsonContains('report_to', "$codemp");

            $data = $data->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addColumn('checkbox', function($row){
                    $checkbox = '<div class="form-check form-check-sm p-3 form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                                </div>';
                    return $checkbox;
                })
                ->addColumn('name', function($row){
                    $name = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1 text-danger">'.$row->getemp->name_en.'</a></div>';
                    $name .= '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->getemp->name_ar.'</a></div>';
                    return $name;
                })
                ->addColumn('email', function($row){
                    $email = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->created_at.'</a></div>';
                    return $email;
                })
                ->addColumn('status', function($row){
                    if($row->status == 'read') {
                        $status = '<div class="badge badge-light-success fw-bold">تم المشاهدة</div>';
                    } else {
                        $status = '<div class="badge badge-light-danger fw-bold">لم يتم المشاهدة</div>';
                    }

                    return $status;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route($this->route.'.response', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-envelope-at-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == 'read' || $request->get('status') == 'unread') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('name','LIKE', "%$search%")
                            ->orWhere('phone','LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['name', 'email','status','checkbox','actions'])
                ->make(true);
        }
        return view($this->viewPath .'.reportcc');
    }
    public function show($id)
    {
        $data = $this->objectModel::find($id);
        return view($this->viewPath .'.show', compact('data'));
    }

    public function create()
    {
        return view($this->viewPath .'.create');
    }

    public function store(Request $request)
    {
        $description = Str::replace(['<p>', '</p>'], '', $request->input('description'));
        $rule = [
            'receiver_id' => 'required|exists:employees,id',
            'description' => 'required',
            'photo' => 'nullable',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
            $row = Message::create([
                'emp_id' => auth('superadmin')->user()->id,
                'description' => $description,
                'status' => 0,
                'receiver_type' => 0,
                'receiver_id' => json_encode($request['receiver_id']),
                'report_to' => json_encode($request['report_to']),
                'sender_type'=> 0,
                'sender_id'=> Auth::guard('superadmin')->user()->id,
            ]);
           
        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $row->addMediaFromRequest('photo')->toMediaCollection('messages');
        }

        return redirect(route($this->route . '.index'))->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }

    public function edit($id)
    {
        $data = $this->objectModel::find($id);
        return view($this->viewPath .'.edit', compact('data'));
    }

    public function update(Request $request)
    {

        $rule = [
            'description' => 'nullable',
            'photo' => 'nullable',
            'status' => 'nullable',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }

        $data = Message::find($request->id);
        $data->update([
            'name' => auth('superadmin')->user()->name_ar,
            'email' => auth('superadmin')->user()->email,
            'phone' => auth('superadmin')->user()->phone,
            'description' => $request->description,
            'status' => 'unread',
            'receiver_type' => 'user',
            'receiver_id' => $request->receiver_id,
            'sender_type'=>'user',
            'sender_id'=> auth('superadmin')->user()->id,
        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $data->addMediaFromRequest('photo')->toMediaCollection('messages');
        }

        return redirect(route($this->route . '.index'))->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {

        try{
            $this->objectModel::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }

    public function response($id)
    {
        $data = $this->objectModel::find($id);
        if ($data->sender_type == 0) {
            $data->update([
                'status' => 1,
            ]);
        }
        
        return view($this->viewPath .'.response', compact('data'));
    }
    public function send_response(Request $request, $message_id)
    {
        $description = Str::replace(['<p>', '</p>'], '', $request->input('description'));

        $rule = [
            'response' => 'nullable',
            'status' => 'nullable',
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }
        $message = Message::find($message_id);
        
        $row = MessagesResponse::create([
            'message_id'=> $message->id,
            'response' => $description,
            'status' => 0 ,
            'receiver_type' => 0,
            'receiver_id' => json_encode($message['receiver_id']),
            'sender_type'=> 0 ,
            'sender_id'=> Auth::guard('superadmin')->user()->id,
        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $row->addMediaFromRequest('photo')->toMediaCollection('messages');
        }


        return redirect(route($this->route . '.response', $message_id))->with('message', 'تم ارسال الرد بنجاح')->with('status', 'success');
    }
    public function SendNotification($user_type, $user, $title, $msg, $title_ar, $msg_ar, $ref_id = null, $ref_type = 1, $type = 0, $store = true, $replace = [])
    {
        if ($store) {
            $notify = new Notification();
            $notify->destination_type = $user_type;
            $notify->destination_id = $user->id;
            $notify->title = $title;
            $notify->message = $msg;
            $notify->title_ar = $title_ar;
            $notify->message_ar = $msg_ar;
            $notify->ref_id = @$ref_id;
            $notify->ref_type = @$ref_type;
            $notify->type = $type;
            $notify->save();
        }
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        if (isset($user->device_token) && $user->device_token != null) {
            $registrationIds = [$user->device_token];
            $serverKey = 'AAAATwzMMRE:APA91bG6u9BWCsR8ARwnoQajZMBiyFGcDom7dmyNu0CRDIfPvVnXRNKhOyudMrw-4nvIn_76EeStVhgNB3CD6Pu1tlaFJ1f8U_zXIFMaG4KoumpU4ZVYiAZJaca0T4F-KSba9DsFYtKS';
            if ($user_type == 3) {
                $message = array
                (
                    'body' => (app()->getLocale() == 'en') ? $msg : $msg_ar,
                    'title' => (app()->getLocale() == 'en') ? $title : $title_ar,
                    'sound' => true,
                );
            } else {
                $message = array
                (
                    'body' => ($user->getAppLocale() == 'en') ? $msg : $msg_ar,
                    'title' => ($user->getAppLocale() == 'en') ? $title : $title_ar,
                    'sound' => true,
                );
            }
            $extraNotificationData = ["ref_id" => $ref_id, "ref_type" => $ref_type, "type" => $type];
            $fields = [
                'registration_ids' => $registrationIds,
                'notification' => $message,
                'data' => $extraNotificationData
            ];
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];
            if ($user->is_notifiable == true) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $fcmUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                curl_close($ch);
            }
            return true;
        } else {
            return false;
        }
    }
}
