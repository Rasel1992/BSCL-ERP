<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Imports\DepartmentsImport;
use App\Models\Department;
use Illuminate\Http\Request;
use Excel;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $departments = Department::latest()->paginate(10);
            return view('admin.department.index', compact('departments'));
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
        return view('admin.department.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $data = $request->except('_token');
            Department::create($data);
            return redirect()->back()->withSuccess('Department created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('admin.department.create-edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentRequest $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            $data = $request->except('_token');
            $department->update($data);
            return redirect()->back()->withSuccess('Department updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();
            return redirect()->back()->withSuccess('Department trashed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function ImportExcel(Request $request) {
        //Validation
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file'); //GET FILE
            Excel::import(new DepartmentsImport, $file); //IMPORT FILE
            return redirect()->back()->withSuccess('Upload file data Department !');
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}
