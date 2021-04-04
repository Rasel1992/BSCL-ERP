<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $users = User::get();
        return view('admin.request.requisition.create', compact('users'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
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
