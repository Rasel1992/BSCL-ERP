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
        $sql = Category::where('parent_id', 0)->with('nested')->orderBy('id', 'asc');
        if ($request->q) {
            $sql->whereHas('nested', function ($q) use ($request) {
                $q->where('category_name', 'LIKE', $request->q . '%');
            });
            $sql->orWhere('category_name', 'LIKE', $request->q . '%');
        }
        if ($request->type) {
            $sql->where('type', $request->type);
        }
        $categoryData = $sql->paginate(10);
        return view('admin.category.index', compact('categoryData'));
    }

    public function create()
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        Category::create($data);
        return redirect()->route('admin.categories.index', qArray())->withSuccess('Category created successfully.');
    }

    public function show(Category $category)
    {
        if (empty($category)) {
            return redirect()->route('admin.categories.index');
        }
        $cat = Category::where('categories.id', $category->id)
            ->select('categories.*', 'B.category_name AS parent_name')
            ->leftJoin('categories AS B', 'B.id', '=', 'categories.parent_id')
            ->first();

        return view('admin.category.show', compact('cat'));
    }

    public function edit(Category $category)
    {
        if (empty($category)) {
            return redirect()->route('admin.categories.index');
        }
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData', 'category'));

    }

    public function update(CategoryRequest $request, Category $category)
    {
        if (empty($category)) {
            return redirect()->route('admin.categories.index');
        }
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
        if (empty($category)) {
            return redirect()->route('admin.categories.index');
        }
        $category->delete();
        return redirect()->route('admin.categories.index', qArray())->withSuccess('Category deleted successfully.');
    }
}
