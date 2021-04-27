<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts= Shift::paginate(10);
        return view('admin.attendance.shift.index', compact('shifts'));
    }

    public function create()
    {
        return view('admin.attendance.shift.create-edit');
    }

    public function store(ShiftRequest $request)
    {
        $data = $request->all();
        Shift::create($data);
        return redirect()->route('admin.shifts.index', qArray())->withSuccess('Shift created successfully.');
    }

    public function edit(Shift $shift)
    {
        if (empty($shift)) {
            return redirect()->route('admin.shifts.index');
        }
        return view('admin.attendance.shift.create-edit', compact('shift'));
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        try {
            if (empty($shift)) {
                return redirect()->route('admin.shifts.index');
            }

            $data = $request->all();
            $shift->update($data);
            return redirect()->route('admin.shifts.index', qArray())->withSuccess('Shift updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Shift $shift)
    {
        try {
            if (empty($shift)) {
                return redirect()->route('admin.shifts.index', qArray());
            }
            $shift->delete();
            return redirect()->route('admin.shifts.index', qArray())->withSuccess('Shift trashed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
