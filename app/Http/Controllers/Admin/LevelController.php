<?php

namespace App\Http\Controllers\Admin;

use App\Models\level;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }
    public function levelShow()
    {
        $levels = level::withCount('users', 'subjects')->get();
        return view('admin.levels.show', compact('levels'));
    }
    public function levelCreate()
    {
        $levels = level::get();
        return view('admin.levels.create', compact('levels'));
    }
    public function levelStore(Request $request)
    {
        $validated = $request->validate([
            'level_name' => 'required|unique:levels,level_name',

        ]);
        try {
            $stored = level::create([
                'level_name' => $request->level_name,
            ]);

            if ($stored) {
                session()->flash('success', 'level added successfuly');
                return redirect()->route('admin.level.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.level.show');
        }
    }
    public function levelEdit($id)
    {
        $level = level::find($id);
        return view('admin.levels.edit', compact('level'));
    }
    public function levelUpdate(Request $request, $id)
    {
        $level = level::find($id);

        $validated = $request->validate([
            'level_name' => 'required|' . Rule::unique('levels', 'id')->ignore($level->id),
        ]);
        try {
            $updated = level::where('id', $level->id)->update([
                'level_name' => $request->level_name,
            ]);
            if ($updated) {
                session()->flash('success', 'level updated successfly');
                return redirect()->route('admin.level.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.level.show');
        }
    }
    public function delete($id)
    {
        try {
            $deleted = Level::find($id)->delete();
            if ($deleted) {
                session()->flash('success', 'level deleted successfuly');
                return redirect()->route('admin.level.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.level.show');
        }
    }
}
