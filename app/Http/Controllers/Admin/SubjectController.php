<?php

namespace App\Http\Controllers\Admin;

use App\Models\level;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Course;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function subjectShow()
    {
        $subjects = Subject::with('level', 'teacher')->get();
        return view('admin.subjects.show', compact('subjects'));
    }
    public function subjectCreate()
    {
        $levels = level::get();
        $teachers = Teacher::get();
        return view('admin.subjects.create', compact('levels', 'teachers'));
    }
    public function subjectStore(Request $request)
    {
        //  return $request;
        $validated = $request->validate([
            'name' => 'required|unique:subjects,name',
            'level_id' => 'required',
            'teacher_id' => 'required',
            'details' => 'required|min:8',

        ]);
        try {
            $stored = Subject::create([
                'name' => $request->name,
                'level_id' => $request->level_id,
                'teacher_id' => $request->teacher_id,
                'details' => $request->details,
            ]);

            if ($stored) {
                session()->flash('success', 'subject added successfuly');
                return redirect()->route('admin.subject.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.subject.show');
        }
    }
    public function subjectEdit($id)
    {
        $levels = level::get();
        $teachers = Teacher::get();
        $subject = Subject::with('level', 'teacher')->find($id);
        return view('admin.subjects.edit', compact('subject', 'levels', 'teachers'));
    }
    public function subjectUpdate(Request $request, $id)
    {
        $subject = Subject::find($id);

        $validated = $request->validate([
            'name' => 'required|' . Rule::unique('subjects', 'id')->ignore($subject->id),
            'level_id' => 'required',
            'teacher_id' => 'required',
            'details' => 'required|min:8',
        ]);
        try {
            $updated = Subject::where('id', $subject->id)->update([
                'name' => $request->name,
                'level_id' => $request->level_id,
                'teacher_id' => $request->teacher_id,
                'details' => $request->details,
            ]);
            if ($updated) {
                session()->flash('success', 'subject updated successfly');
                return redirect()->route('admin.subject.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.subject.show');
        }
    }
    public function delete($id)
    {
        try {
            $deleted = Subject::find($id)->delete();

            if ($deleted) {
                $course = Course::where('subject_id', $id)->delete();
                session()->flash('success', 'subject deleted successfuly');
                return redirect()->route('admin.subject.show');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.subject.show');
        }
    }
}
