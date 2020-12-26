<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.create-edit', compact('categoryData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData', 'stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        try {
            $stock->delete();
            return redirect()->back()->withSuccess('Stock deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
