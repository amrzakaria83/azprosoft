<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartReport;
use DataTables;
use Validator;
use Auth;
use Carbon\Carbon;

class TicketController extends Controller
{

    public function index(Request $request)
    {
        $data = Ticket::get();

        if ($request->ajax()) {
            $data = Ticket::query();
            $data = $data->where('user_id', Auth::user()->id)->orderBy('id', 'DESC');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('project', function($row){
                    $project = '<div class="d-flex flex-column"><a href="javascript:;" class="text-gray-800 text-hover-primary mb-1">'.$row->project.'</a>';
                    return $project;
                })
                ->addColumn('name_rd', function($row){

                    $name_rd = $row->name_rd;

                    return $name_rd;
                })
                ->addColumn('price_rd', function($row){

                    $price_rd = $row->price_rd;

                    return $price_rd;
                })
                ->addColumn('bdg', function($row){
                    if($row->bdg == 1) {
                        $bdg = '<div class="badge badge-light-success fw-bold">مستخدم</div>';
                    } else {
                        $bdg = '<div class="badge badge-light-danger fw-bold">غير مستخدم</div>';
                    }

                    return $bdg;
                })
                ->addColumn('actions', function($row){
                    $actions = '<div class="ms-2">
                                <a href="'.route('client.tickets.show', $row->id).'" class="btn btn-sm btn-icon btn-warning btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-eye-fill fs-1x"></i>
                                </a>
                                <a href="'.route('client.tickets.print', $row->id).'" class="btn btn-sm btn-icon btn-info btn-active-dark me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-printer-fill fs-1x"></i>
                                </a>
                            </div>';
                    return $actions;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('bdg') == '0' || $request->get('bdg') == '1') {
                        $instance->where('bdg', $request->get('bdg'));
                    }
                    if (!empty($request->get('search'))) {
                            $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('project', 'LIKE', "%$search%")
                            ->orWhere('name_rd', 'LIKE', "%$search%")
                            ->orWhere('barcode', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['project','name_rd','bdg','price_rd','actions'])
                ->make(true);
        }
        return view('client.ticket.index');
    }

    public function show($id)
    {
        $data = Ticket::find($id);
        return view('client.ticket.show', compact('data'));
    }

    public function create()
    {
        return view('client.ticket.create');
    }

    public function store(Request $request)
    {
        $rule = [
            'project' => 'required|string',
            'name_rd' => 'required|string',
            'price_rd' => 'required',
            'date' => 'required'
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }

        $tickets = [];
        $year = Carbon::now('y')->format('y');
        $thisSession = rand(1111,9999);

        // $tticket = Ticket::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        // if (isset($tticket->barcode)) {
        //     $tticket = substr($tticket->barcode, -5) ;
        // } else {
        //     $tticket = 11111 ;
        // }

        // $barcode = $year . $thisSession .Auth::user()->id. ($tticket+1);

        for ($i=1; $i < ($request->qty + 1); $i++) {
            $barcode = $year . $i .$thisSession . rand(111,999).Auth::user()->id;
            $tticket = Ticket::where('barcode', $barcode)->get();
            if (count($tticket) > 0) {
                $barcode = $year . $i .$thisSession . rand(111,999).Auth::user()->id;
            }

            $row = Ticket::create([
                'project' => $request->project,
                'name_rd' => $request->name_rd,
                'price_rd' => $request->price_rd,
                'date' => $request->date,
                'barcode' => $barcode,
                'user_id' => Auth::user()->id,
                'bdg' => '0',
            ]);

            $tickets[] = [
                'project' => $request->project,
                'name_rd' => $request->name_rd,
                'price_rd' => $request->price_rd,
                'date' => $request->date,
                'barcode' => $barcode,
                'user_id' => Auth::user()->id,
                'bdg' => '0',
            ];
        }

        return view('client.ticket.tickets', compact('tickets'))->with('message', 'تم الاضافة بنجاح')->with('status', 'success');
    }

    public function print($id)
    {
        $tickets = Ticket::where('id', $id)->get();
        return view('client.ticket.tickets', compact('tickets'));
    }

    public function checkticket()
    {
        $cartreport = cartReport::where('user_id', Auth::user()->id)->get();
        $data = cart::where('user_id', Auth::user()->id)->get();
        return view('client.ticket.check-tickets', compact('data','cartreport'));
    }

    public function itemticket(Request $request)
    {
        $ticket = Ticket::where('user_id', Auth::user()->id)->where('bdg', 0)->where('barcode', $request->itm_ticket)->get();
        if (count($ticket) == 0) {
            return response()->json(['msg' => 'faild']);
        } else {
            $row = cart::create([
                'project' => $ticket[0]->project,
                'name_rd' => $ticket[0]->name_rd,
                'price_rd' => $ticket[0]->price_rd,
                'date' => $ticket[0]->date,
                'barcode' => $ticket[0]->barcode,
                'user_id' => Auth::user()->id
            ]);

            $checkreports = cartReport::where('project', $ticket[0]->project)
            ->where('name_rd', $ticket[0]->name_rd)
            ->where('price_rd', $ticket[0]->price_rd)
            ->get();

            if (count($checkreports) == 0) {
                $row = cartReport::create([
                    'project' => $ticket[0]->project,
                    'name_rd' => $ticket[0]->name_rd,
                    'price_rd' => $ticket[0]->price_rd,
                    'qty' => 1,
                    'user_id' => Auth::user()->id
                ]);
            } else {
                cartReport::where('id', $checkreports[0]->id)->update([
                    'qty' => $checkreports[0]->qty + 1,
                ]);
            }

            Ticket::where('barcode', $ticket[0]->barcode)->update([
                'bdg' => 1,
            ]);


            $cartreport = cartReport::where('user_id', Auth::user()->id)->get();
            $data = cart::where('user_id', Auth::user()->id)->get();
            return view('client.ticket.check-item-ticket', compact('data','cartreport'));
        }

    }

    public function DeleteCart(Request $request)
    {
        $id = $request->id;

        try {
            Cart::where('id', $id)->delete();
        } catch (\Exception $e) {

        }

        $data = cart::where('user_id', Auth::user()->id)->get();
        return view('client.ticket.check-item-ticket', compact('data'));
    }

    public function alldeletordercart(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)->delete();
        cartReport::where('user_id', Auth::user()->id)->delete();

        $cartreport = cartReport::where('user_id', Auth::user()->id)->get();
        $data = cart::where('user_id', Auth::user()->id)->get();
        return view('client.ticket.check-item-ticket', compact('data','cartreport'));
    }

    public function edit($id)
    {
        $data = Ticket::find($id);
        return view('client.ticket.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $rule = [
            'name' => 'required|string',
            'company_name' => 'required|string',
            'email' => 'email|unique:tickets,email,'.$request->id,
            'phone' => 'required|unique:tickets,phone,'.$request->id,
            'password' => 'nullable',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ];

        $validate = Validator::make($request->all(), $rule);
        if ($validate->fails()) {
            return redirect()->back()->with('message', $validate->messages()->first())->with('status', 'error');
        }

        $data = Ticket::find($request->id);
        $data->update([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => ($request->password) ? Hash::make($request->password): $data->password,
            'commercial' => $request->commercial,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active ?? '0',
        ]);

        if($request->hasFile('photo') && $request->file('photo')->isValid()){
            $data->addMediaFromRequest('photo')->toMediaCollection('profile');
        }

        return redirect('tickets')->with('message', 'تم التعديل بنجاح')->with('status', 'success');
    }

    public function destroy(Request $request)
    {

        try{
            Ticket::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
        return response()->json(['message' => 'success']);

    }
}
