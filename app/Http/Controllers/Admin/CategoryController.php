<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['categoryData'] = Category::where('parent_id', 0)->with('nested')->get();
        $sql = Category::orderBy('categories.id', 'DESC');

        $sql->select('categories.*', 'B.category_name AS parent_name', 'C.category_name AS parent_mother', \DB::raw('IFNULL(D.subCount,0) AS subCount'));
        $sql->leftJoin('categories AS B', 'B.id','=','categories.parent_id');
        $sql->leftJoin('categories AS C', 'C.id','=','B.parent_id');
//        if ($request->q) {
//        $sql->where('category_name ', 'LIKE', $request->q . '%');
//    }
//        if ($request->type) {
//            $sql->where('type', $request->type);
//        }
        $sql->leftJoin(\DB::raw('(SELECT parent_id, COUNT(id) AS subCount FROM categories GROUP BY parent_id) AS D'), 'categories.id','=','D.parent_id');
        $data['categories'] = $sql->latest()->paginate(10);
//        $categories = Category::get();
//        $data['categories'] = Category::where('parent_id', 0)->get();
//        $data['all'] = $categories->count();
//        $data['categoryData'] = Category::where('parent_id', 0)
//            ->with('nested')
//            ->get();

        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->except('_token');
        $category = Category::create($data);
        if ($request->ajax()) {
            return response()->json(['data' => $category, 'msg' => 'Category created successfully.']);
        }
        return redirect()->back()->withSuccess('Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category = Category::where('categories.id', $category->id)
            ->select('categories.*', 'B.category_name AS parent_name')
            ->leftJoin('categories AS B', 'B.id','=','categories.parent_id')
            ->first();

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categoryData = Category::where('parent_id', 0)->with('nested')->get();
        return view('admin.category.create-edit', compact('categoryData', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $input = $request->all();
        $updateData = [
            'parent_id' => $input['parent_id'],
            'category_name' => $input['category_name'],
        ];
        $data = $category;
        $data->update($updateData);

        return redirect()->back()->withSuccess('Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->withSuccess('Category deleted successfully.');
    }
}
