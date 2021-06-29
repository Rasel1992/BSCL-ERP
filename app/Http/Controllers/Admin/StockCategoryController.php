<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockCategoryRequest;
use App\Models\StockCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('see stock category list')) {
            return view('errors.403');
        }

        $sql = StockCategory::where('parent_id', 0)->with('nested')->orderBy('category_name', 'asc');
        if ($request->q) {
            $sql->whereHas('nested', function ($q) use ($request) {
                $q->where('category_name', $request->q);
                $q->orWhere('category_code', $request->q);
            });
            $sql->orWhere('category_name', $request->q);
        }
        $categoryData = $sql->paginate(50);
        $serial = (!empty($request->page)) ? ((50*($request->page - 1)) + 1) : 1;
        return view('admin.stock.category.index', compact('categoryData', 'serial'));
    }

    public function create()
    {
        if (!Auth::user()->can('add stock category')) {
            return view('errors.403');
        }

        $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.category.create-edit', compact('categoryData'));
    }

    public function store(StockCategoryRequest $request)
    {
        if (!Auth::user()->can('add stock category')) {
            return view('errors.403');
        }

        $storeData = [
            'parent_id' => $request->parent_id,
            'category_name' => $request->category_name,
        ];

        if($request->parent_id != 0) {
            $storeData['category_code'] = $request->category_code;
        }
        StockCategory::create($storeData);
        return redirect()->route('admin.stock-category.index', qArray())->withSuccess('Category created successfully.');
    }

    public function show(StockCategory $stockCategory)
    {
        if (!Auth::user()->can('see stock category details')) {
            return view('errors.403');
        }

        if (empty($stockCategory)) {
            return redirect()->route('admin.stock-category.index');
        }
        $cat = StockCategory::where('stock_categories.id', $stockCategory->id)
            ->select('stock_categories.*', 'B.category_name AS parent_name')
            ->leftJoin('stock_categories AS B', 'B.id', '=', 'stock_categories.parent_id')
            ->first();

        return view('admin.stock.category.show', compact('cat'));
    }

    public function edit(StockCategory $stockCategory)
    {
        if (!Auth::user()->can('edit stock category')) {
            return view('errors.403');
        }

        if (empty($stockCategory)) {
            return redirect()->route('admin.stock-category.index');
        }
        $categoryData = StockCategory::where('parent_id', 0)->with('nested')->get();
        return view('admin.stock.category.create-edit', compact('categoryData', 'stockCategory'));

    }

    public function update(StockCategoryRequest $request, StockCategory $stockCategory)
    {
        if (!Auth::user()->can('edit stock category')) {
            return view('errors.403');
        }

        if (empty($stockCategory)) {
            return redirect()->route('admin.stock-category.index');
        }
        $updateData = [
            'parent_id' => $request->parent_id,
            'category_name' => $request->category_name,
        ];

        if($request->category_code && $request->parent_id != 0) {
            $updateData['category_code'] = $request->category_code;
        }

        $stockCategory->update($updateData);

        return redirect()->route('admin.stock-category.index', qArray())->withSuccess('Category updated successfully.');
    }

    public function CategoryCodeAjax(Request $request)
    {
        $code = StockCategory::select('id', 'category_code')->where('id', $request->category_id)->first();
        return response()->json(['status' => true, 'code' => $code]);
    }
}
