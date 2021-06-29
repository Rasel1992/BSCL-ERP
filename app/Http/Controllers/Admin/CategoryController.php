<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('see category list')) {
            return view('errors.403');
        }

        $sql = Category::where('parent_id', 0)->with('nested')->orderBy('category_name', 'asc');
        if ($request->q) {
            $sql->whereHas('nested', function ($q) use ($request) {
                $q->where('category_name', $request->q);
                $q->orWhere('category_code', $request->q);
            });
            $sql->orWhere('category_name', $request->q);
        }
        if ($request->type) {
            $sql->where('type', $request->type);
        }
        $categoryData = $sql->paginate(50);
        $serial = (!empty($request->page)) ? ((50*($request->page - 1)) + 1) : 1;
        return view('admin.inventory.category.index', compact('categoryData', 'serial'));
    }

    public function create()
    {
        if (!Auth::user()->can('add category')) {
            return view('errors.403');
        }

        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.category.create-edit', compact('categoryData'));
    }

    public function store(CategoryRequest $request)
    {
        if (!Auth::user()->can('add category')) {
            return view('errors.403');
        }

        $storeData = [
            'parent_id' => $request->parent_id,
            'type' => $request->type,
            'category_name' => $request->category_name,
        ];

        if($request->parent_id != 0) {
            $storeData['category_code'] = $request->category_code;
        }
        Category::create($storeData);
        return redirect()->route('admin.inventory-category.index', qArray())->withSuccess('Category created successfully.');
    }

    public function show($id)
    {
        if (!Auth::user()->can('see category details')) {
            return view('errors.403');
        }
        $category = Category::where('id', $id)->first();
        if (empty($category)) {
            return redirect()->route('admin.inventory-category.index');
        }

        $cat = Category::where('categories.id', $category->id)
            ->select('categories.*', 'B.category_name AS parent_name')
            ->leftJoin('categories AS B', 'B.id', '=', 'categories.parent_id')
            ->first();

        return view('admin.inventory.category.show', compact('cat'));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit category')) {
            return view('errors.403');
        }
        $category = Category::where('id', $id)->first();
        if (empty($category)) {
            return redirect()->route('admin.inventory-category.index');
        }
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.inventory.category.create-edit', compact('categoryData', 'category'));

    }

    public function update(CategoryRequest $request, $id)
    {
        if (!Auth::user()->can('edit category')) {
            return view('errors.403');
        }
        $category = Category::where('id', $id)->first();
        if (empty($category)) {
            return redirect()->route('admin.inventory-category.index');
        }
        $updateData = [
            'parent_id' => $request->parent_id,
            'type' => $request->type,
            'category_name' => $request->category_name,
        ];

        if($request->category_code && $request->parent_id != 0) {
            $updateData['category_code'] = $request->category_code;
        }

        $category->update($updateData);

        return redirect()->route('admin.inventory-category.index', qArray())->withSuccess('Category updated successfully.');
    }

    public function CategoryCodeAjax(Request $request)
    {
        $code = Category::select('id', 'category_code')->where('id', $request->category_id)->first();
        return response()->json(['status' => true, 'code' => $code]);
    }
}
