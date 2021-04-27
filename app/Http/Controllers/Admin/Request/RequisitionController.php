<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
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
        return view('admin.request.requisition.requisition', compact('requisition_to'))->with('list', 1);
    }

    public function send()
    {
        $requisition_by = Requisition::where('requisition_by', Auth::user()->id)->paginate(10);
        return view('admin.request.requisition.requisition', compact('requisition_by'))->with('send', 1);
    }

    public function create()
    {
        $users = User::where('type','admin')->where('id','!=',Auth::user()->id)->get();
        return view('admin.request.requisition.requisition', compact('users'))->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sl_number' => 'required|integer',
            'requisition_to' => 'required|integer',
            'actual_user' => 'nullable|string',
            'requisition_date' => 'required|date',
            'requisition_by_sign' => 'nullable|string',
            'verified_by' => 'nullable|string',
            'approved_by' => 'nullable|string',
            'received_by' => 'nullable|string',
            'disbursed_by' => 'nullable|string',
            's_no' => 'nullable|array',
            's_no.*' => 'required|integer',
            'item_code' => 'nullable|array',
            'item_code.*' => 'required|string',
            'particulars' => 'nullable|array',
            'particulars.*' => 'required|string',
            'qty' => 'nullable|array',
            'qty.*' => 'required|numeric',
            'disbursement' => 'nullable|array',
            'disbursement.*' => 'required|string',
        ]);
        $storeData = [
            'sl_number' => $request->sl_number,
            'requisition_to' => $request->requisition_to,
            'requisition_by' => Auth::user()->id,
            'actual_user' => $request->actual_user,
            'requisition_date' => $request->requisition_date,
        ];

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
            return redirect()->route('admin.request.requisition.requisition');
        }
        $users = User::where('type','admin')->where('id','!=',Auth::user()->id)->get();
        return view('admin.request.requisition.requisition', compact('data', 'users'));
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
