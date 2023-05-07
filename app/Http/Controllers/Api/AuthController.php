<?php

namespace App\Http\Controllers\Api;

use random;
use Validator;
use Carbon\Carbon;
use Faker\Factory;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function userRegister(Request $request)
    {


        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required|min:8|unique:users,username',
                'phone' => 'required|unique:users,phone',
                'school' => 'required',
                'birthdate' => 'required|date',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'level_id' => 'required',
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'phone' => $request->phone,
            'school' => $request->school,
            'birthdate' => $request->birthdate,
            'level_id' => $request->level_id,
            'image' => "default.png",
            'email_verified_at' => Carbon::now(),
        ]);

        if (auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'user']);

            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp', ['user'])->accessToken;

            return response()->json($success, 200);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'user']);

            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp', ['user'])->accessToken;

            return response()->json($success, 200);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }
    public function userProfile()
    {
        $user = Auth::user('user');
        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function userUpdateProfile(Request $request)
    {
        $user = Auth::user('user');
        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required|min:8|unique:users,username,' . $user->id,
                'phone' => 'required|unique:users,phone,' . $user->id,
                'school' => 'required',
                'birthdate' => 'required|date',
                'level_id' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'image' => 'mimes:jpeg,bmp,png'
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if ($request->image) {
            if ($user->image != 'default.png') {
                File::delete('uploads/images/users/' . $user->image);
            }
            $file = $request->file('image');
            $filename = $user->username .  time() . '.' . $file->extension();
            $path = public_path() . '/uploads/images/users/';
            $file->move($path, $filename);
            $request['profile'] = $filename;
        } else {
            $request['profile'] = $user->image;
        }

        if ($request->password) {
            $user = User::where('id', $user->id)->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => $request->username,
                'phone' => $request->phone,
                'school' => $request->school,
                'birthdate' => $request->birthdate,
                'level_id' => $request->level_id,
                'image' => $request['profile'],

            ]);
        } else {
            $user = User::where('id', $user->id)->update([
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'school' => $request->school,
                'birthdate' => $request->birthdate,
                'level_id' => $request->level_id,
                'image' => $request['profile'],
            ]);
        }
        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function userResetPassword(Request $request)
    {

        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'phone' => 'required',
                'email' => 'required|email'
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::where(['username' => $request->username, 'email' => $request->email, 'phone' => $request->phone])->first();
        if ($user) {
            $faker = Factory::create();
            $new_password = $faker->regexify('[A-Z]{5}[0-4]{3}');
            $user->update([
                'password' => Hash::make($new_password),
            ]);
            return response()->json(['new_password' => $new_password], 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function userLogout()
    {
        $user = Auth::user()->token();
        $revoked = $user->revoke();

        if ($revoked) {
            return response()->json('logged out', 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function teacherRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:8|unique:teachers,username',
            'phone' => 'required|unique:teachers,phone',
            'school' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'about' => 'required',
            'email_verified_at' => Carbon::now(),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        Teacher::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'phone' => $request->phone,
            'school' => $request->school,
            'birthdate' => $request->birthdate,
            'about' => $request->about,
            'image' => "default.png",
        ]);
        if (auth()->guard('teacher')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'teacher']);

            $teacher = teacher::select('teachers.*')->find(auth()->guard('teacher')->user()->id);
            $success =  $teacher;
            $success['token'] =  $teacher->createToken('MyApp', ['teacher'])->accessToken;

            return response()->json($success, 200);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }
    public function teacherLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (auth()->guard('teacher')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'teacher']);

            $teacher = teacher::select('teachers.*')->find(auth()->guard('teacher')->user()->id);
            $success =  $teacher;
            $success['token'] =  $teacher->createToken('MyApp', ['teacher'])->accessToken;

            return response()->json($success, 200);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }
    public function teacherProfile()
    {
        $teacher = Auth::user('teacher');

        if ($teacher) {
            return response()->json($teacher, 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function teacherLogout()
    {
        $revoked = Auth::user('teacher')->token()->revoke();
        if ($revoked) {
            return response()->json('logged out', 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function teacherUpdateProfile(Request $request)
    {
        $teacher = Auth::user('teacher');
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:8|' . Rule::unique('teachers', 'id')->ignore($teacher->id),
            'phone' => 'required|' . Rule::unique('teachers', 'id')->ignore($teacher->id),
            'school' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email|' . Rule::unique('teachers', 'id')->ignore($teacher->id),
            'about' => 'required',
            'image' => 'mimes:jpeg,bmp,png'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if ($request->image) {
            if ($teacher->image != 'default.png') {
                File::delete('uploads/images/teachers/' . $teacher->image);
            }
            $file = $request->file('image');
            $filename = $teacher->username . time() . '.' . $file->extension();
            $path = public_path() . '/uploads/images/teachers/';
            $file->move($path, $filename);
            $request['profile'] = $filename;
        } else {
            $request['profile'] = $teacher->image;
        }
        if ($request->password) {
            Teacher::where('id', $teacher->id)->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => $request->username,
                'phone' => $request->phone,
                'school' => $request->school,
                'birthdate' => $request->birthdate,
                'about' => $request->about,
                'image' => $request['profile'],
            ]);
        } else {
            Teacher::where('id', $teacher->id)->update([
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'school' => $request->school,
                'birthdate' => $request->birthdate,
                'about' => $request->about,
                'image' => $request['profile'],
            ]);
        }

        if ($teacher) {
            return response()->json($teacher, 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
    public function teacherResetPassword(Request $request)
    {

        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'phone' => 'required',
                'email' => 'required|email'
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = Teacher::where(['username' => $request->username, 'email' => $request->email, 'phone' => $request->phone])->first();
        if ($user) {
            $faker = Factory::create();
            $new_password = $faker->regexify('[A-Z]{5}[0-4]{3}');
            $user->update([
                'password' => Hash::make($new_password),
            ]);
            return response()->json(['new_password' => $new_password], 200);
        } else {
            return response()->json(['error' => ['some thing went wrong Wrong.']], 200);
        }
    }
}
