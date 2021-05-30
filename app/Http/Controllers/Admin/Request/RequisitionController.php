<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitionController extends Controller
{
    public function index()
    {
        $requisition_to = Requisition::where('requisition_to', Auth::user()->id)->paginate(10);
        $approved_to = Requisition::where('approved_to', Auth::user()->id)->paginate(10);
        $received_to = Requisition::where('received_to', Auth::user()->id)->paginate(10);
        $disbursed_to = Requisition::where('disbursed_to', Auth::user()->id)->paginate(10);
        if(!empty($requisition_to) && $requisition_to !==null){
            return view('admin.request.requisition.requisition', compact('requisition_to'))->with('list', 1);
        }

//        $verified_to = Requisition::where('verified_to', Auth::user()->id)->paginate(10);
//        if($verified_to){
//
//            return view('admin.request.requisition.requisition-verified', compact('verified_to'))->with('list', 1);
//        }


        if($approved_to){
            return view('admin.request.requisition.requisition-approved', compact('approved_to'))->with('list', 1);
        }


        if($received_to){
            return view('admin.request.requisition.requisition-received', compact('received_to'))->with('list', 1);
        }


        if($disbursed_to){
            return view('admin.request.requisition.requisition-disbursed', compact('disbursed_to'))->with('list', 1);
        }
        else{
            dd('kkk');
        }
    }

    public function send()
    {
        $requisition_by = Requisition::where('requisition_by', Auth::user()->id)->paginate(10);
        if($requisition_by){
            return view('admin.request.requisition.requisition', compact('requisition_by'))->with('send', 1);
        }

        $verified_by = Requisition::where('verified_by', Auth::user()->id)->paginate(10);
        if($verified_by){
            return view('admin.request.requisition.requisition-verified', compact('verified_by'))->with('send', 1);
        }

        $approved_by = Requisition::where('approved_by', Auth::user()->id)->paginate(10);
        if($approved_by){
            return view('admin.request.requisition.requisition-approved', compact('approved_by'))->with('send', 1);
        }

        $received_by = Requisition::where('received_by', Auth::user()->id)->paginate(10);
        if($received_by){
            return view('admin.request.requisition.requisition-received', compact('received_by'))->with('send', 1);
        }

        $disbursed_by = Requisition::where('disbursed_by', Auth::user()->id)->paginate(10);
        if($disbursed_by){
            return view('admin.request.requisition.requisition-disbursed', compact('disbursed_by'))->with('send', 1);
        }
    }

    public function create()
    {
        $users = User::where('type','admin')->where('id','!=',Auth::user()->id)->get();
        return view('admin.request.requisition.requisition', compact('users'))->with('create', 1);
    }

    public function store(Request $request)
    {
//        $this->validate($request, [
//            'sl_number' => 'required|integer',
//            'requisition_to' => 'required|integer',
//            'actual_user' => 'nullable|string',
//            'requisition_date' => 'required|date',
//            'requisition_by_sign' => 'nullable|string',
//            'verified_by' => 'nullable|string',
//            'approved_by' => 'nullable|string',
//            'received_by' => 'nullable|string',
//            'disbursed_by' => 'nullable|string',
//            's_no' => 'nullable|array',
//            's_no.*' => 'required|integer',
//            'item_code' => 'nullable|array',
//            'item_code.*' => 'required|string',
//            'particulars' => 'nullable|array',
//            'particulars.*' => 'required|string',
//            'qty' => 'nullable|array',
//            'qty.*' => 'required|numeric',
//            'disbursement' => 'nullable|array',
//            'disbursement.*' => 'required|string',
//        ]);
        $storeData = [
            'sl_number' => $request->sl_number,
            'requisition_to' => $request->requisition_to,
            'requisition_by' => Auth::user()->id,
            'actual_user' => $request->actual_user,
            'requisition_date' => $request->requisition_date,
        ];

        $user_id = Auth::user()->id;

        if ($request->hasFile('signature')) {

            $image = (new MediaController())->imageUpload($request->file('signature'), 'user/signature', 1);
            $data['signature'] = $image['name'];

            $user = User::where('id', $user_id)->first();
            $user->update($data);
        }
        $requisition = Requisition::create($storeData);

        if ($request->only('s_no')) {
            $data = [];
            foreach ($request->s_no as $key => $row) {
                $data[] = [
                    'requisition_id' => $requisition->id,
                    'item_code' => $request->item_code[$key],
                    'particulars' => $request->particulars[$key],
                    'qty' => $request->qty[$key],
                    'disbursement' => $request->disbursement[$key],
                ];
            }
            RequisitionItem::insert($data);
        }
        return redirect()->route('admin.request.requisition.index')->withSuccess('Requisition form submit successfully.');
    }

    public function show($id)
    {
        $data = Requisition::where('id', $id)->first();

        if (empty($data)) {
            return redirect()->route('admin.request.requisition.requisition');
        }

        $users = User::where('type','admin')->where('id','!=',Auth::user()->id)->get();

        return view('admin.request.requisition.requisition', compact('data', 'users'))->with('show', $id);
    }


    public function edit($id)
    {
        $data = Requisition::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->route('admin.request.requisition.index');
        }
        $users = User::where('type','admin')->where('id','!=',Auth::user()->id)->get();
        return view('admin.request.requisition.requisition', compact('data', 'users'))->with('edit', $id);
    }


    public function update(Request $request, $id)
    {
        try {
            if (!Auth::user()->can('edit shift')) {
                return view('errors.403');
            }

            $requisition = Requisition::where('id', $id)->first();

            if (empty($requisition)) {
                return redirect()->route('admin.request.requisition.index');
            }

            if ($request->only('approved_to', 'verified_status')) {

                $data = [
                    'approved_to' => $request->approved_to,
                    'verified_status' => $request->verified_status,
                    'payment_method_id' => $request->payment_method_id,
                ];

                $requisition->update($data);
            }

            return redirect()->route('admin.request.requisition.index', qArray())->withSuccess('Requisition updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
