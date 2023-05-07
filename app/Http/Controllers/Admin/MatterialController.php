<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SubjectMatterial;
use App\Http\Controllers\Controller;

class MatterialController extends Controller
{
    public function show()
    {
        $matterials = SubjectMatterial::with('subject')->with('subject', function ($q) {
            return $q->with('teacher');
        })->get();
        return view('admin.matterials.show', compact('matterials'));
    }
    public function matterialsShow()
    {
        $matterials = SubjectMatterial::with('subject')->with('subject', function ($q) {
            return $q->with('teacher');
        })->get();
        return response()->json($matterials, 200);
    }
    public function create()
    {
        $subjects = Subject::get();
        return view('admin.matterials.create', compact('subjects'));
    }
    public function store(Request $request)
    {
        //return $request->details;
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|numeric',
            'name' => 'required|string|unique:subject_matterials,name',
            'details' => 'required|string',
            'src' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $stored = SubjectMatterial::create([
                'subject_id' => $request->subject_id,
                'name' => $request->name,
                'details' => $request->details,
                'src' => $request->src,
            ]);

            if ($stored) {
                session()->flash('success', 'matterial added successfuly');
                return redirect()->route('admin.matterial.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('error', 'some thing wen wrong please try again later');
            return redirect()->route('admin.matterial.show');
        }
    }
    public function edit($id)
    {
        $subjects = Subject::get();
        $matterial = SubjectMatterial::with('subject')->find($id);
        return view('admin.matterials.edit', compact('subjects', 'matterial'));
    }
    public function update(Request $request, $id)
    {
        $matterial = SubjectMatterial::with('subject')->find($id);
        // return $request;
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|numeric',
            'name' => 'required|string|' . Rule::unique('subject_matterials', 'name')->ignore($matterial->id),
            'details' => 'required|string',
            'src' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $stored = $matterial->update([
                'subject_id' => $request->subject_id,
                'name' => $request->name,
                'details' => $request->details,
                'src' => $request->src,
            ]);

            if ($stored) {
                session()->flash('success', 'matterial updated successfuly');
                return redirect()->route('admin.matterial.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('error', 'some thing wen wrong please try again later');
            return redirect()->route('admin.matterial.show');
        }
    }
    public function delete($id)
    {
        try {
            $deleted = SubjectMatterial::find($id)->delete();
            if ($deleted) {
                session()->flash('success', 'matterial deleted successfuly');
                return redirect()->route('admin.matterial.show');
            }
        } catch (\Throwable $th) {
            return $th;
            session()->flash('error', 'some thing wen wrong please try again later');
            return redirect()->route('admin.matterial.show');
        }
    }
}
