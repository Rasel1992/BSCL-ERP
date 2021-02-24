<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sql = Category::where('parent_id', 0)
        ->with('nested')
            ->orderBy('id', 'asc');
        if ($request->q) {
            $sql->where('category_name', 'LIKE', $request->q . '%');
        }
        if ($request->type) {
            $sql->where('type', $request->type);
        }
        $categoryData = $sql->paginate(10);
        return view('admin.category.index', compact('categoryData'));
    }

    public function updateOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->ids as $key => $id) {
            Category::where('id', $id)->update(['sorting' => $key]);
        }

        return response()->json(['msg' => 'Categories sorted successfully.']);
    }

    public function create()
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->except('_token');
        Category::create($data);
        return redirect()->route('admin.categories.index', qArray())->withSuccess('Category created successfully.');
    }

    public function show(Category $category)
    {
        $category = Category::where('categories.id', $category->id)
            ->select('categories.*', 'B.category_name AS parent_name')
            ->leftJoin('categories AS B', 'B.id','=','categories.parent_id')
            ->first();

        return view('admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData', 'category'));

    }

    public function update(CategoryRequest $request, Category $category)
    {
        $input = $request->all();
        $updateData = [
            'parent_id' => $input['parent_id'],
            'category_name' => $input['category_name'],
            'type' => $input['type'],
        ];
        $data = $category;
        $data->update($updateData);

        return redirect()->route('admin.categories.index', qArray())->withSuccess('Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index', qArray())->withSuccess('Category deleted successfully.');
    }
}
