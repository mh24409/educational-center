<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use Carbon\Carbon;
// use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class UserCoursesController extends Controller
{
    public function show()
    {
        $courses = Course::withCount('users')->with('subject', function ($q) {
            return $q->with('teacher');
        })->get();
        return view('admin.courses.show', compact('courses'));
    }
    public function create()
    {
        $subjects = Subject::get();
        return view('admin.courses.create', compact('subjects'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'details' => 'required|string',
            'firstday' => 'required|in:sunday,monday,tuesday,wednesday,thursday,saturday,friday',
            'firstdaytime' => 'required|in:first,second,third,fourth',
            'secondday' => 'in:sunday,monday,tuesday,wednesday,thursday,saturday',
            'seconddaytime' => 'in:first,second,third,fourth',
            'image' => 'mimes:jpeg,bmp,png',
            'no_of_students' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'subject_id' => 'required|numeric|unique:courses,subject_id',
        ]);
        try {
            $imagename = 'default.png';
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = substr($request->details, 0, 5) . time() . '.' . $file->extension();
                $path = public_path() . '/uploads/images/courses/';
                $file->move($path, $filename);
                $imagename = $filename;
            }
            $stored = Course::create([
                'details' => $request->details,
                'firstday' => $request->firstday,
                'firstdaytime' => $request->firstdaytime,
                'secondday' => $request->secondday,
                'seconddaytime' => $request->seconddaytime,
                'image' => $imagename,
                'no_of_students' => $request->no_of_students,
                'no_of_avilables' => $request->no_of_students,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'subject_id' => $request->subject_id,
            ]);
            if ($stored) {
                session()->flash('success', 'course created successfuly');
                return redirect()->route('admin.course.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('success', 'course created successfuly');
            return redirect()->route('admin.course.show');
        }
    }
    public function edit($id)
    {
        $course = Course::with('subject')->find($id);
        $subjects = Subject::get();
        return view('admin.courses.edit', compact('course', 'subjects'));
    }
    public function update(Request $request, $id)
    {
        //return $request;
        $course = Course::find($id);
        $validated = $request->validate([
            'details' => 'required|string',
            'firstday' => 'required|in:sunday,monday,tuesday,wednesday,thursday,saturday,friday',
            'firstdaytime' => 'required|in:first,second,third,fourth',
            'secondday' => 'in:sunday,monday,tuesday,wednesday,thursday,saturday',
            'seconddaytime' => 'in:first,second,third,fourth',
            'image' => 'mimes:jpeg,bmp,png',
            'no_of_students' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'subject_id' => 'required|numeric|' . Rule::unique('courses', 'id')->ignore($course->id),
            // 'status' => 'boolean'
        ]);
        try {
            $status_value = false;
            if ($request->status == "on") {
                $status_value = true;
            }
            if ($request->image) {
                $imagename = null;
                if ($course->image != 'default.png') {
                    File::delete('uploads/images/courses/' . $course->image);
                }
                $file = $request->file('image');
                $filename = substr($request->details, 0, 5) . time() . '.' . $file->extension();
                $path = public_path() . '/uploads/images/courses/';
                $file->move($path, $filename);
                $imagename = $filename;
                $updated = $course->update([
                    'details' => $request->details,
                    'firstday' => $request->firstday,
                    'firstdaytime' => $request->firstdaytime,
                    'secondday' => $request->secondday,
                    'seconddaytime' => $request->seconddaytime,
                    'image' => $imagename,
                    'no_of_students' => $request->no_of_students,
                    'no_of_avilables' => $request->no_of_avilables,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'subject_id' => $request->subject_id,
                    'status' => $status_value,
                ]);
            } else {
                $updated = $course->update([
                    'details' => $request->details,
                    'firstday' => $request->firstday,
                    'firstdaytime' => $request->firstdaytime,
                    'secondday' => $request->secondday,
                    'seconddaytime' => $request->seconddaytime,
                    'no_of_students' => $request->no_of_students,
                    'no_of_avilables' => $request->no_of_avilables,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'subject_id' => $request->subject_id,
                    'status' => $status_value,
                ]);
            }



            if ($updated) {
                session()->flash('success', 'course updated successfuly');
                return redirect()->route('admin.course.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('success', 'course updated successfuly');
            return redirect()->route('admin.course.show');
        }
    }
    public function enrollToCourse(Request $request)
    {
        $user = User::with('courses')->find(Auth::user('user')->id);
        $course = Course::find($request->course_id);
        $validate = Validator::make(
            $request->all(),
            [
                'course_id' => 'required|' . Rule::unique('user_courses')->where(function ($query) use ($course, $user) {
                    return $query->where('course_id', $course->id)
                        ->where('user_id', $user->id);
                }),
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }
        if ($course->no_of_avilables == 0) {
            return response()->json([
                'status' => true,
                'message' => 'this course is full',
                'errors' =>  "sorry , this course is full check later if any student disenroll from this course"
            ], 401);
        } else {
            foreach ($user->courses as $usercourse) {
                if ($course->start_date >= $usercourse->start_date &&  $usercourse->end_date >= $course->start_date) {
                    if ($usercourse->firstday == $course->firstday && $usercourse->firstdaytime == $course->firstdaytime || $usercourse->secondday == $course->secondday && $usercourse->seconddaytime == $course->seconddaytime) {
                        return response()->json([
                            'status' => false,
                            'message' => 'validation error',
                            'errors' =>  "sorry you can't enroll to this course , your already enroll to course in same period or same day and time"
                        ], 401);
                    }
                }
            }
            try {
                $course->users()->attach($user->id, ['firstday' => $course->firstday, 'firstdaytime' => $course->firstdaytime, 'secondday' => $course->secondday, 'seconddaytime' => $course->seconddaytime, 'start_date' => $course->start_date, 'end_date' => $course->end_date,]);
                $course->update(['no_of_avilables' => $course->no_of_avilables - 1]);
                return response()->json(['success' => ['course enrolled successfuly.']], 200);
            } catch (\Throwable $th) {
                return $th;
                return response()->json(['error' => ['some thing went wrong']], 401);
            }
        }
    }
    public function disenrollToCourse(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required',
        ]);
        try {
            $user = Auth::user('user');
            // $user = User::find($user_id);
            $course = Course::find($request->course_id);
            //delete user from this course
            $disenrolled = $course->users()->detach($user->id);
            $decreased =  $course->update(['no_of_avilables' => $course->no_of_avilables + 1]);
            return response()->json(['success' => ['course disenrolled successfuly.']], 200);
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['error' => ['some thing went wrong']], 404);
        }
    }
    public function delete($id)
    {
        try {
            $deleted = Course::find($id)->delete();
            if ($deleted) {
                session()->flash('success', 'course deleted successfuly');
                return redirect()->route('admin.course.show');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.course.show');
        }
    }
}
