<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Homework;
use App\Models\Message;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Subject;
use App\Models\SubjectMatterial;
use Illuminate\Http\Request;
use Validator;
use App\Models\Teacher;
use App\Models\TeacherUserFeedback;
use App\Models\UserQuezGrade;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function teacherShow()
    {
        $teachers = Teacher::get();
        return view('admin.teachers.show', compact('teachers'));
    }
    public function teacherCreate()
    {
        return view('admin.teachers.create');
    }
    public function teacherStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|min:8|unique:teachers,username',
            'phone' => 'required|unique:teachers,phone',
            'school' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'about' => 'required',

        ]);
        try {

            $stored = Teacher::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => $request->username,
                'phone' => $request->phone,
                'school' => $request->school,
                'birthdate' => $request->birthdate,
                'about' => $request->about,
                'image' => 'default.png',
            ]);

            if ($stored) {
                session()->flash('success', 'teacher added successfuly');
                return redirect()->route('admin.teacher.show');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.teacher.show');
        }
    }
    public function teacherEdit($id)
    {
        $teacher = Teacher::find($id);
        return view('admin.teachers.edit', compact('teacher'));
    }
    public function teacherUpdate(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        $validated = $request->validate([
            'username' => 'required|min:8|' . Rule::unique('teachers', 'username')->ignore($teacher->id),
            'phone' => 'required|' . Rule::unique('teachers', 'phone')->ignore($teacher->id),
            'school' => 'required',
            'birthdate' => 'required|date',
            'email' => 'required|email|' . Rule::unique('teachers', 'email')->ignore($teacher->id),
            'about' => 'required',
            'image' => 'mimes:jpeg,bmp,png'
        ]);
        try {
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
                $updated = Teacher::where('id', $teacher->id)->update([
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
                $updated = Teacher::where('id', $teacher->id)->update([
                    'email' => $request->email,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'school' => $request->school,
                    'birthdate' => $request->birthdate,
                    'about' => $request->about,
                    'image' => $request['profile'],
                ]);
            }
            if ($updated) {
                session()->flash('success', 'teacher updated successfuly');
                return redirect()->route('admin.teacher.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.teacher.show');
        }
    }
    public function teacherVerifyEmail($id)
    {
        $teacher = Teacher::find($id);
        $status = '';
        if ($teacher->email_verified_at == null) {
            $actived = Teacher::where('id', $teacher->id)->update([
                'email_verified_at' => Carbon::now(),
            ]);
            $status = 'active';
        } else {
            $inactived = Teacher::where('id', $teacher->id)->update([
                'email_verified_at' => null,
            ]);
            $status = 'inactive';
        }

        if ($status == 'active') {
            session()->flash('success', 'user email verified successfuly');
            return redirect()->route('admin.teacher.show');
        } elseif ($status == 'inactive') {
            session()->flash('success', 'user email disprove successfuly');
            return redirect()->route('admin.teacher.show');
        }
    }
    public function delete($id)
    {
        try {
            $teacher = Teacher::find($id);
            $default = Teacher::where('email', 'defaultTeacher@example.com')->first();
            $subject = Subject::where('teacher_id', $teacher->id)->first();
            $subject->update(['teacher_id' => $default->id]);
            $teacher->delete();



            session()->flash('success', 'teacher deleted successfuly and his/her associates');
            return redirect()->route('admin.teacher.show');
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.teacher.show');
        }
    }
}
