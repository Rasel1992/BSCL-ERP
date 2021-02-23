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
//        $data['categoryData'] = Category::where('parent_id', 0)->with('nested')->get();
//        $sql = Category::orderBy('categories.id', 'DESC');
//
//        $sql->select('categories.*', 'B.category_name AS parent_name', 'C.category_name AS parent_mother', \DB::raw('IFNULL(D.subCount,0) AS subCount'));
//        $sql->leftJoin('categories AS B', 'B.id','=','categories.parent_id');
//        $sql->leftJoin('categories AS C', 'C.id','=','B.parent_id');
//
//        $sql->leftJoin(\DB::raw('(SELECT parent_id, COUNT(id) AS subCount FROM categories GROUP BY parent_id) AS D'), 'categories.id','=','D.parent_id');
//        $data['categories'] = $sql->latest()->paginate(10);


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


//        $data['categoryData'] = Category::where('parent_id', 0)
//        ->with('nested')
//        ->paginate(10);
//        dd($data);
//        $data['categoryData'] = auth()->user()->store->categories()->where('status', 1)->where('parent_id', 0)->with('nested')->get();
        return view('admin.category.index', compact('categoryData'));
    }
    public function all(): \Illuminate\Http\JsonResponse
    {
        $request = \request();
        $keyword = $request->keyword ?? '';
        $sortBy = $request->sort_by ?? 'sorting';
        $orderBy = $request->order_by ?? 'desc';

        $categories = Category::with(['nested' => function($q) use($request) {
                if ($request->status) {
                    $q->where('status', $request->status);
                }
                $q->with(['nested' => function($query) use($request) {
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                }]);
            }])
            ->select('categories.*'/*, DB::raw('IFNULL(B.orderCount, 0) AS orderCount'), DB::raw('IFNULL(C.allProducts, 0) AS allProducts'), DB::raw('IFNULL(D.activeProducts, 0) AS activeProducts'), DB::raw('IFNULL(E.inactiveProducts, 0) AS inactiveProducts')*/)
            ->where('parent_id', 0)
            ->where(function ($q) use ($request) {
                if ($request->status) {
                    $q->where('status', $request->status);
                }
            })
            ->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('category_name', 'LIKE', '%' . $keyword . '%');
                }
            })
            /*->leftJoin(DB::raw("(SELECT COUNT(id) AS orderCount, admin_id FROM order_details GROUP BY admin_id) AS B"), 'admins.id', '=', 'B.admin_id')
            ->leftJoin(DB::raw("(SELECT COUNT(id) AS allProducts, brand_id FROM products GROUP BY category_id) AS C"), 'categories.id', '=', 'C.category_id')
            ->leftJoin(DB::raw("(SELECT COUNT(id) AS activeProducts, category_id FROM products WHERE status='active' GROUP BY category_id) AS D"), 'categories.id', '=', 'D.category_id')
            ->leftJoin(DB::raw("(SELECT COUNT(id) AS inactiveProducts, category_id FROM products WHERE status='inactive' GROUP BY category_id) AS E"), 'categories.id', '=', 'E.category_id')*/
            ->orderBy($sortBy, $orderBy)
            ->paginate(10);

        return response()->json($categories);
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
