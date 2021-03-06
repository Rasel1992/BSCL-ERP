<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BillRegister;
use App\Models\Category;
use Illuminate\Http\Request;

class BillRegisterController extends Controller
{
    public function index()
    {
        try {
            $data['categoryData'] = Category::where('parent_id', 0)->with('nested')->get();
            $sql = Category::orderBy('categories.id', 'DESC');
            $sql->select('categories.*', 'B.category_name AS parent_name', 'C.category_name AS parent_mother', \DB::raw('IFNULL(D.subCount,0) AS subCount'));
            $sql->leftJoin('categories AS B', 'B.id','=','categories.parent_id');
            $sql->leftJoin('categories AS C', 'C.id','=','B.parent_id');
            $sql->leftJoin(\DB::raw('(SELECT parent_id, COUNT(id) AS subCount FROM categories GROUP BY parent_id) AS D'), 'categories.id','=','D.parent_id');
            $data['categories'] = $sql->get();
            $bills = BillRegister::latest()->paginate(10);
            return view('admin.bill-register.index', compact('bills', 'data'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.bill-register.create-edit', compact('categoryData'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->except('_token');
            BillRegister::create($data);
            return redirect()->back()->withSuccess('Bill register created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(BillRegister $billRegister)
    {
        //
    }

    public function edit(BillRegister $billRegister)
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.bill-register.create-edit', compact('categoryData', 'billRegister'));
    }

    public function update(Request $request, BillRegister $billRegister)
    {
        try {
            $data = $request->except('_token');
            $billRegister->update($data);
            return redirect()->back()->withSuccess('Bill register updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(BillRegister $billRegister)
    {
        try {
            $billRegister->delete();
            return redirect()->back()->withSuccess('Bill register deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
