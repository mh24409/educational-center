<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\level;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function userShow()
    {
        $users = User::get();
        return view('admin.users.show', compact('users'));
    }
    public function userCreate()
    {
        $levels = level::get();
        return view('admin.users.create', compact('levels'));
    }
    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:8|unique:users,username',
            'phone' => 'required|unique:users,phone',
            'school' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'level_id' => 'required',

        ]);
        try {
            $stored = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => $request->username,
                'phone' => $request->phone,
                'school' => $request->school,
                'birthdate' => $request->birthdate,
                'level_id' => $request->level_id,
                'image' => 'default.png',
            ]);

            if ($stored) {
                session()->flash('success', 'user added successfuly');
                return redirect()->route('admin.user.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.user.show');
        }
    }
    public function userEdit($id)
    {
        $user = User::find($id);
        $levels = level::get();
        return view('admin.users.edit', compact('user', 'levels'));
    }
    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);

        $validated = $request->validate([
            'username' => 'required|min:8|' . Rule::unique('users', 'id')->ignore($user->id),
            'phone' => 'required|' . Rule::unique('users', 'id')->ignore($user->id),
            'school' => 'required',
            'level_id' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email|' . Rule::unique('users', 'id')->ignore($user->id),
            'image' => 'mimes:jpeg,bmp,png'
        ]);
        try {
            if ($request->image) {
                if ($user->image != 'default.png') {
                    File::delete('uploads/images/users/' . $user->image);
                }
                $file = $request->file('image');
                $filename = $user->username . time() . '.' . $file->extension();
                $path = public_path() . '/uploads/images/users/';
                $file->move($path, $filename);
                $request['profile'] = $filename;
            } else {
                $request['profile'] = $user->image;
            }

            if ($request->password) {
                $updated = User::where('id', $user->id)->update([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'school' => $request->school,
                    'level_id' => $request->level_id,
                    'birthdate' => $request->birthdate,
                    'image' => $request['profile'],
                ]);
            } else {
                $updated = User::where('id', $user->id)->update([
                    'email' => $request->email,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'school' => $request->school,
                    'level_id' => $request->level_id,
                    'birthdate' => $request->birthdate,
                    'image' => $request['profile'],
                ]);
            }
            if ($updated) {
                session()->flash('success', 'user updated successfuly');
                return redirect()->route('admin.user.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.user.show');
        }
    }
    public function userVerifyEmail($id)
    {
        $user = User::find($id);
        $status = '';

        if ($user->email_verified_at == null) {
            $actived = User::where('id', $user->id)->update([
                'email_verified_at' => Carbon::now(),
            ]);
            $status = 'active';
        } else {
            $inactived = User::where('id', $user->id)->update([
                'email_verified_at' => null,
            ]);
            $status = 'inactive';
        }
        if ($status == 'active') {
            session()->flash('success', 'user email verified successfuly');
            return redirect()->route('admin.user.show');
        } elseif ($status == 'inactive') {
            session()->flash('success', 'user email disprove successfuly');
            return redirect()->route('admin.user.show');
        }
    }
    public function delete($id)
    {
        try {
            $deleted = User::find($id)->delete();
            if ($deleted) {
                session()->flash('success', 'user deleted successfuly');
                return redirect()->route('admin.user.show');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.user.show');
        }
    }
}
