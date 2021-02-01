<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use App\Http\Requests\ProfileRequest;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function index()
    {
        try {
            $id = auth()->user()->id;
            $user = User::find($id);
            return view('admin.account.profile', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update user profile.
     *
     * @param ProfileRequest $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $input = $request->except('_token');
            User::updateOrCreate(['id' => $id], $input);
            return redirect()->back()->withSuccess('Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update user profile Image.
     *
     * @param ProfileRequest $request
     * @return RedirectResponse
     */

    public function updateImage(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $user = User::first();
            $data = $request->except('_token');

            if ($request->hasFile('image')) {
                if ($user && $user->image) {
                    (new MediaController())->delete('user', $user->image);
                }
                $image = (new MediaController())->imageUpload($request->file('image'),'user', 1);
                $data['image'] = $image['name'];
            }
            User::updateOrCreate(['id' => $id], $data);
            return redirect()->back()->withSuccess('Image updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show user password form.
     *
     * @return RedirectResponse
     */

    public function passwordForm(){
        try {
            return view('admin.account.change-password');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update user password.
     *
     * @param ProfileRequest $request
     * @return RedirectResponse
     */

    public function updatePassword(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $input = $request->all();
            $userData = User::find($id);

            if (!Hash::check($input['old_password'], $userData->password)) {
                return response()->json(['status' => 'success', 'Error' => 'The specified password does not match the database password']);
            } else {
                $formData = [
                    'password' => bcrypt($input['new_password']),
                ];
                $userData->update($formData);
            }

            return redirect()->back()->withSuccess('Password updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
