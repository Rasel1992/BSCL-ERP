<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\UserRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Roster;
use App\Models\Shift;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('activity')) {
                return view('errors.403');
            }

            $sql = User::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where('name', 'LIKE', $request->q . '%');
                $sql->orWhere('user_id', $request->q );
            }
            if ($request->type) {
                $sql->where('type', $request->type);
            }
            $users = $sql->paginate(10);
            return view('admin.user.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        if (!Auth::user()->can('add user')) {
            return view('errors.403');
        }

        $departments = Department::get();
        if(auth()->user()->type == 'staff')
        {
            $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();
        }
        else
        {
            $roles = Role::pluck('name', 'name')->all();
        }
        return view('admin.user.create-edit', compact('departments', 'roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            if (!Auth::user()->can('add user')) {
                return view('errors.403');
            }

            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $data['email_verified_at'] = now();
            if ($request->hasFile('image')) {
                $image = (new MediaController())->imageUpload($request->file('image'), 'user', 1);
                $data['image'] = $image['name'];
            }
            if ($request->hasFile('signature')) {
                $image = (new MediaController())->imageUpload($request->file('signature'), 'user/signature', 1);
                $data['signature'] = $image['name'];
            }
            $user = User::create($data);
            $user->assignRole($request->role);
            return redirect()->route('admin.users.index', qArray())->withSuccess('User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        if (!Auth::user()->can('see user details')) {
            return view('errors.403');
        }

        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return redirect()->route('admin.users.index');
        }
        $userRole = $user->roles->pluck('name', 'name')->first();
        $totalWorkHours = Roster::select( DB::raw('time(sum(TIMEDIFF( shifts.to, shifts.from )))  AS totalHour'))->join('shifts', 'shifts.id', '=', 'rosters.shift_id')->where('rosters.user_id', $user->id)->first();
        return view('admin.user.details', compact('user', 'totalWorkHours', 'userRole'));
    }

    public function edit(User $user)
    {
        if (!Auth::user()->can('edit user')) {
            return view('errors.403');
        }

        if (empty($user)) {
            return redirect()->route('admin.users.index');
        }
        $departments = Department::get();

        if(auth()->user()->type == 'staff')
        {
            $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();
        }
        else
        {
            $roles = Role::pluck('name', 'name')->all();
        }
        return view('admin.user.create-edit', compact('user', 'departments', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            if (!Auth::user()->can('edit user')) {
                return view('errors.403');
            }

            if (empty($user)) {
                return redirect()->route('admin.users.index');
            }

            $data = $request->all();
            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            } else {
                unset($data['password']);
            }
            if ($request->hasFile('image')) {
                if ($user && $user->image) {
                    (new MediaController())->delete('user', $user->image, 1);
                }
                $image = (new MediaController())->imageUpload($request->file('image'), 'user', 1);
                $data['image'] = $image['name'];
            }
            if ($request->hasFile('signature')) {
                if ($user && $user->signature) {
                    (new MediaController())->delete('user/signature', $user->signature, 1);
                }
                $image = (new MediaController())->imageUpload($request->file('signature'), 'user/signature', 1);
                $data['signature'] = $image['name'];
            }
            $user->update($data);
            $user->assignRole($request->role);
            return redirect()->route('admin.users.index', qArray())->withSuccess('User Updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, User $user)
    {
        try {
            if (!Auth::user()->can('delete user')) {
                return view('errors.403');
            }

            if (empty($user)) {
                return redirect()->route('admin.users.index');
            }
            if ($user && $user->image) {
                (new MediaController())->delete('user', $user->image, 1);
            }
            if ($user && $user->signature) {
                (new MediaController())->delete('user/signature', $user->signature, 1);
            }
            $user->delete();
            return redirect()->route('admin.users.index', qArray())->withSuccess('User deleted!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function passwordUpdate(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|max:255|confirmed'
        ]);

        try {
            $user->update(['password' => bcrypt($request->password)]);
            return redirect()->route('admin.users.index', qArray())->withSuccess('User\'s password updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
