<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Department;
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
        $data = Stock::where('id', $id)->first();
        $users = User::get();
        $departments = Department::get();
        return view('admin.stock.assign-stock', compact('data', 'users', 'departments'));
    }

    public function assignStock(Request $request, $id){
        $stock_id = $id;
        $data = Stock::where('id', $stock_id)->first();

        if ($data->qty < $request->qty) {
            return redirect()->route('admin.stocks.index')->withErrors(['error' => 'Qty not in stock!']);
        }
        $updateData = [
            'qty' => $data->qty - $request->qty,
        ];
        $data->update($updateData);
        $storeData = [
            'qty' => $request->qty,
            'stock_id' => $request->stock_id,
            'assign_to' => $request->assign_to,
            'user_id' => $request->user_id,
            'dept_id' => $request->dept_id,
            'assign_date' => $request->assign_date,
        ];
        StockUser::create($storeData);
        return redirect()->route('admin.stocks.assigned-stock')->withSuccess('Stock Assigned successfully.');
    }

    public function summary()
    {
        try {

            $categories_head = Category::where('type', 'Stock')->with(['stocks' => function($q) {
                $q->where('location','hq');
            }])
                ->get();

            $categories_gs1 = Category::where('type', 'Stock')->with(['stocks' => function($q) {
                $q->where('location','gs1');
            }])
                ->get();
            $categories_gs2 = Category::where('type', 'Stock')->with(['stocks' => function($q) {
                $q->where('location','gs2');
            }])
                ->get();
            return view('admin.stock.summary', compact( 'categories_head', 'categories_gs1', 'categories_gs2'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function categoryStocks($id) {
        $data['category'] = $category = Category::where('id', $id)->find($id);
        $data['stocks'] = Stock::where('category_id', $category->id)->paginate(15);

        return view('admin.stock.summary-show', compact('data', 'category'));
    }
}
