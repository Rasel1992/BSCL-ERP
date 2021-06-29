<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DepartmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Imports\DepartmentsImport;
use App\Models\Department;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('see department list')) {
                return view('errors.403');
            }

            $sql = Department::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where(function ($q) use ($request) {
                    $q->orWhere('department', 'LIKE', $request->q . '%');
                    $q->orWhere('department_id', $request->q);
                });
            }
            $departments = $sql->paginate(50);
            $serial = (!empty($request->page)) ? ((50*($request->page - 1)) + 1) : 1;
            return view('admin.department.index', compact('departments', 'serial'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        if (!Auth::user()->can('add department')) {
            return view('errors.403');
        }

        return view('admin.department.create-edit');
    }

    public function store(DepartmentRequest $request)
    {
        try {
            if (!Auth::user()->can('add department')) {
                return view('errors.403');
            }

            $data = $request->all();
            Department::create($data);
            return redirect()->route('admin.departments.index', qArray())->withSuccess('Department created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Department $department)
    {
        if (!Auth::user()->can('see department details')) {
            return view('errors.403');
        }

        if (empty($department)) {
            return redirect()->route('admin.departments.index');
        }
        return view('admin.department.details', compact('department'));
    }

    public function edit(Department $department)
    {
        if (!Auth::user()->can('edit department')) {
            return view('errors.403');
        }

        if (empty($department)) {
            return redirect()->route('admin.departments.index');
        }
        return view('admin.department.create-edit', compact('department'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            if (!Auth::user()->can('edit department')) {
                return view('errors.403');
            }

            if (empty($department)) {
                return redirect()->route('admin.departments.index');
            }

            $data = $request->all();
            $department->update($data);
            return redirect()->route('admin.departments.index', qArray())->withSuccess('Department updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Department $department)
    {
        try {
            if (!Auth::user()->can('delete department')) {
                return view('errors.403');
            }

            if (empty($department)) {
                return redirect()->route('admin.departments.index', qArray());
            }
            $department->delete();
            return redirect()->route('admin.departments.index', qArray())->withSuccess('Department trashed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function ImportExcel(Request $request)
    {
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
