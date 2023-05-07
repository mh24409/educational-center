<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Course;
use App\Models\Homework;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function show()
    {
        $homeworks = Homework::with('course')->with('course', function ($q) {
            return $q->with('subject')->with('subject', function ($qq) {
                return $qq->with('teacher');
            });
        })->get();
        return view('admin.homeworks.show', compact('homeworks'));
    }
    public function create()
    {
        $courses = Course::with('subject')->get();
        return view('admin.homeworks.create', compact('courses'));
    }
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'src' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $stored = Homework::create([
                'course_id' => $request->course_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'src' => $request->src,
            ]);

            if ($stored) {
                session()->flash('success', 'homework added successfuly');
                return redirect()->route('admin.homework.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('error', 'some thing wen wrong please try again later');
            return redirect()->route('admin.homework.show');
        }
    }
    public function edit($id)
    {
        $courses = Course::with('subject')->get();
        $homework = Homework::with('course')->find($id);
        return view('admin.homeworks.edit', compact('homework', 'courses'));
    }
    public function update(Request $request, $id)
    {
        $homework = Homework::with('course')->find($id);
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'src' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $stored = $homework->update([
                'course_id' => $request->course_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'src' => $request->src,
            ]);

            if ($stored) {
                session()->flash('success', 'homework updated successfuly');
                return redirect()->route('admin.homework.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('error', 'some thing wen wrong please try again later');
            return redirect()->route('admin.homework.show');
        }
    }
    public function delete($id)
    {
        try {
            $deleted = Homework::find($id)->delete();
            if ($deleted) {
                session()->flash('success', 'homework deleted successfuly');
                return redirect()->route('admin.homework.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('error', 'some thing wen wrong please try again later');
            return redirect()->route('admin.homework.show');
        }
    }
    public function studentAnswerHomework(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'homework_id' => 'required|numeric',
            'src' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $homework = Homework::find($request->homework_id);
            $homework->users()->attach(Auth::user('user')->id, ['src' => $request->src]);

            return response()->json(['success' => 'homework submited']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'error , try again later']);
        }
    }
}
