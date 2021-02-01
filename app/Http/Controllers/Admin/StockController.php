<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Stock;
use App\Models\StockUser;
use App\User;
use Illuminate\Http\Request;

class StockController extends Controller
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
            $stocks = Stock::latest()->paginate(10);
            return view('admin.stock.index', compact('stocks', 'data'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function assignedStock()
    {
        try {
            $data['categoryData'] = Category::where('parent_id', 0)->with('nested')->get();
            $sql = Category::orderBy('categories.id', 'DESC');
            $sql->select('categories.*', 'B.category_name AS parent_name', 'C.category_name AS parent_mother', \DB::raw('IFNULL(D.subCount,0) AS subCount'));
            $sql->leftJoin('categories AS B', 'B.id','=','categories.parent_id');
            $sql->leftJoin('categories AS C', 'C.id','=','B.parent_id');
            $sql->leftJoin(\DB::raw('(SELECT parent_id, COUNT(id) AS subCount FROM categories GROUP BY parent_id) AS D'), 'categories.id','=','D.parent_id');
            $data['categories'] = $sql->get();
            $assignedStocks = StockUser::latest()->paginate(10);
            return view('admin.stock.assigned-stock', compact('assignedStocks', 'data'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $categoryData = Category::where('type', 'Stock')->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData'))->with('create', 1);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->except('_token');
            Stock::create($data);
            return redirect()->back()->withSuccess('Stock created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Stock $stock)
    {
        $categoryData = Category::where('type', 'Stock')->where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData', 'stock'))->with('edit', 1);
    }

    public function update(Request $request, Stock $stock)
    {
        try {
            $data = $request->except('_token');
            $stock->update($data);
            return redirect()->back()->withSuccess('Stock updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Stock $stock)
    {
        try {
            $stock->delete();
            return redirect()->back()->withSuccess('Stock deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function assignStockForm(Request $request, $id){
        $stock_id = $id;
        $users = User::get();
        return view('admin.stock.assign-stock', compact('stock_id', 'users'));
    }

    public function assignStock(Request $request, $id){
        $stock_id = $id;
        $data = Stock::where('id', $stock_id)->first();
        $updateData = [
            'qty' => $data->qty - $request->qty,
        ];
        $data->update($updateData);
        $storeData = [
            'qty' => $request->qty,
            'stock_id' => $request->stock_id,
            'user_id' => $request->user_id,
            'assign_date' => $request->assign_date,
        ];
        StockUser::create($storeData);
        return redirect()->back()->withSuccess('Stock updated successfully.');
    }
}
