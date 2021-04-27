<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\RosterRequest;
use App\Models\Roster;
use App\Models\Shift;
use App\User;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function index(Request $request)
    {
        $rosters = Roster::orderBy('day', 'ASC')->paginate(50);
        $shifts = Shift::get();
        return view('admin.attendance.roster.index', compact('rosters', 'shifts'));
    }

    public function create()
    {
        $users = User::get();
        $shifts = Shift::get();
        return view('admin.attendance.roster.create-edit', compact('users', 'shifts'));
    }

    public function store(RosterRequest $request)
    {
        $data = [];
        foreach ($request->user_id as  $user_id) {
            foreach ($request->day as  $day) {
                foreach ($request->shift_id as  $shift_id) {
                    $data[] = [
                        'roster_date' => $request->roster_date,
                        'user_id' => $user_id,
                        'day' => $day,
                        'shift_id' => $shift_id,
                    ];
                }
            }
        }

        Roster::insert($data);

        return redirect()->route('admin.rosters.index', qArray())->withSuccess('Roster created successfully.');
    }

    public function edit(Roster $roster)
    {
        if (empty($roster)) {
            return redirect()->route('admin.rosters.index');
        }
        $users = User::get();
        $shifts = Shift::get();
        return view('admin.attendance.roster.create-edit', compact('roster', 'users', 'shifts'));
    }

    public function update(RosterRequest $request, Roster $roster)
    {
        try {
            if (empty($roster)) {
                return redirect()->route('admin.rosters.index');
            }

            $data = [];
            foreach ($request->user_id as  $user_id) {
                foreach ($request->day as  $day) {
                    foreach ($request->shift_id as  $shift_id) {
                        $data[] = [
                            'roster_date' => $request->roster_date,
                            'user_id' => $user_id,
                            'day' => $day,
                            'shift_id' => $shift_id,
                        ];
                    }
                }
            }
            $roster->update($data);
            return redirect()->route('admin.rosters.index', qArray())->withSuccess('Roster updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Roster $roster)
    {
        try {
            if (empty($roster)) {
                return redirect()->route('admin.rosters.index', qArray());
            }
            $roster->delete();
            return redirect()->route('admin.rosters.index', qArray())->withSuccess('Roster trashed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
