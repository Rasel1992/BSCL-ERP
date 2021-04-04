<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $sql = User::orderBy('created_at', 'ASC');
            if ($request->q) {
                $sql->where('name', 'LIKE', $request->q . '%');
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
        $departments = Department::get();
        return view('admin.user.create-edit', compact('departments'));
    }

    public function store(UserRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $data['email_verified_at'] = now();
            if ($request->hasFile('image')) {
                $image = (new MediaController())->imageUpload($request->file('image'), 'user', 1);
                $data['image'] = $image['name'];
            }
            User::create($data);
            return redirect()->route('admin.users.index', qArray())->withSuccess('User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(User $user)
    {
        if (empty($user)) {
            return redirect()->route('admin.users.index');
        }
        return view('admin.user.details', compact('user'));
    }

    public function edit(User $user)
    {
        if (empty($user)) {
            return redirect()->route('admin.users.index');
        }
        $departments = Department::get();
        return view('admin.user.create-edit', compact('user', 'departments'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
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

            $user->update($data);
            return redirect()->route('admin.users.index', qArray())->withSuccess('User Updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, User $user)
    {
        try {
            if (empty($user)) {
                return redirect()->route('admin.users.index');
            }
            if ($user && $user->image) {
                (new MediaController())->delete('user', $user->image, 1);
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
