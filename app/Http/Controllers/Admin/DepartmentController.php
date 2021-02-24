<?php

namespace App\Http\Controllers\Admin;
use App\Exports\DepartmentsExport;
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
    public function index(Request $request)
    {
        try {
            $sql = Department::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where(function ($q) use ($request) {
                    $q->orWhere('department', 'LIKE', $request->q . '%');
                    $q->orWhere('designation', 'LIKE', $request->q . '%');
                });
            }
            $departments = $sql->paginate(10);
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

    public function store(DepartmentRequest $request)
    {
        try {
            $data = $request->except('_token');
            Department::create($data);
            return redirect()->route('admin.departments.index')->withSuccess('Department created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Department $department)
    {
        return view('admin.department.details', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('admin.department.create-edit',compact('department'));
    }

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

    public function fileExport()
    {
        return Excel::download(new DepartmentsExport(), 'department-collection.xlsx');
    }

}
