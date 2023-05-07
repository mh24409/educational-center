<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Validator;
use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Admin;
use App\Models\level;
use App\Models\Course;
use App\Models\Message;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Homework;
use Illuminate\Http\Request;
use App\Models\UserQuezGrade;
use Illuminate\Validation\Rule;
use App\Models\SubjectMatterial;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherUserFeedback;
use App\Http\Controllers\Controller;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin')->only('index');
    }
    public function adminShow()
    {
        $admins = Admin::get();
        return view('admin.admins.show', compact('admins'));
    }
    public function adminCreate()
    {
        return view('admin.admins.create');
    }
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed',
        ]);
        try {
            $stored = Admin::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
            ]);

            if ($stored) {
                session()->flash('success', 'admin added successfuly');
                return redirect()->route('admin.admin.show');
            }
        } catch (\Exception $e) {
            return $e;
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.admin.show');
        }
    }
    public function adminEdit($id)
    {
        $admin = Admin::find($id);
        return view('admin.admins.edit', compact('admin'));
    }
    public function adminUpdate(Request $request, $id)
    {

        $admin = Admin::find($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|' . Rule::unique('admins', 'id')->ignore($admin->id),
        ]);
        try {
            if ($request->password) {
                $stored = $admin->update([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'name' => $request->name,
                ]);
            } else {
                $stored = $admin->update([
                    'email' => $request->email,
                    'name' => $request->name,
                ]);
            }
            if ($stored) {
                session()->flash('success', 'admin updated successfuly');
                return redirect()->route('admin.admin.show');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.admin.show');
        }
    }
    public function delete($id)
    {
        try {
            Admin::find($id)->delete();
            session()->flash('success', 'admin updated successfuly');
            return redirect()->route('admin.admin.show');
        } catch (\Exception $e) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.admin.show');
        }
    }
    public function index()
    {
        return view('admin.home');
    }
    public function levels()
    {
        $levels = level::get();
        return response()->json($levels, 200);
    }
    public function subjectsForUser()
    {

        $subjects = Subject::where('level_id', Auth::user('user')->level_id)->with('teacher', 'course', 'matterials')->get();
        return response()->json($subjects, 200);
    }
    public function subjectsForTeacher()
    {

        $subjects = Subject::with('teacher', 'course', 'matterials')->get();
        return response()->json($subjects, 200);
    }
    public function courses()
    {
        // return 'ok';
        $now_date = Carbon::now('Africa/Cairo');
        $d = new DateTime();
        $now_day = $d->format('l');
        $date = $now_date->toArray();
        $courses = Course::with('users')->with('subject', function ($q) {
            return $q->with('teacher');
        })->whereHas('subject', function ($q) {
            $q->where('level_id', Auth::user('user')->level_id);
        })
            ->where('end_date', '>=', $date['year'] . '-' . $date['month'] . '-' . $date['day'])
            ->get();

        foreach ($courses as $index => $course) {
            $indexx = -1;
            $quizzs = Quiz::select('id')->where('course_id', $course->id)->get();
            $first_three_users = UserQuezGrade::with('user')
                ->whereIn('quiz_id', $quizzs)
                ->select('user_id', DB::raw('sum(user_grade) as grade'))
                ->groupBy('user_id')
                ->orderBy('grade', 'desc')
                ->take(3)
                ->get();
            $courses[$index]['logged_user_have_this_course'];
            if ($course->users->isEmpty()) {
                $courses[$index]['logged_user_have_this_course'] = false;
            } else {
                foreach ($course->users as $i => $user) {
                    $courses[$index]['first_three_users'] = $first_three_users;
                    $user_grade = UserQuezGrade::whereIn('quiz_id', $quizzs)
                        ->where('user_id', $user->id)
                        ->select('user_id', DB::raw('sum(user_grade) as grade'))
                        ->groupBy('user_id')
                        ->orderBy('grade', 'desc')
                        ->get();
                    $courses[$index]['users'][$i]['grade'] = $user_grade;

                    if ($user->id == Auth::user('user')->id) {
                        $indexx = $index;
                    } else {
                        $indexx = -1;
                    }
                    if ($indexx != -1) {
                        // return $indexx;
                        $courses[$indexx]['logged_user_have_this_course'] = true;
                    }
                }
            }
        }
        return response()->json($courses, 200);
    }
    public function coursesForTeacher()
    {
        $now_date = Carbon::now('Africa/Cairo');
        $d = new DateTime();
        $now_day = $d->format('l');
        $date = $now_date->toArray();
        $courses = Course::with('users')->with('subject', function ($q) {
            return $q->with('teacher');
        })
            ->where('end_date', '>=', $date['year'] . '-' . $date['month'] . '-' . $date['day'])
            ->get();

        foreach ($courses as $index => $course) {

            $quizzs = Quiz::select('id')->where('course_id', $course->id)->get();
            $first_three_users = UserQuezGrade::with('user')
                ->whereIn('quiz_id', $quizzs)
                ->select('user_id', DB::raw('sum(user_grade) as grade'))
                ->groupBy('user_id')
                ->orderBy('grade', 'desc')
                ->take(3)
                ->get();
            $courses[$index]['first_three_users'] = $first_three_users;
        }
        return response()->json($courses, 200);
    }
    public function teachers()
    {
        $teachers = Teacher::with('subjects')->whereHas('subjects')->get();
        return response()->json($teachers, 200);
    }
    public function students()
    {
        $students = User::with('courses')->get();
        return response()->json($students, 200);
    }
    public function singleSubject($id)
    {
        $subject = Subject::with('teacher', 'course', 'matterials')->find($id);
        return response()->json($subject, 200);
    }
    public function singleCourse($id)
    {
        $course = Course::with('users')->with('subject', function ($q) {
            return $q->with('teacher');
        })->find($id);
        $quizzs = Quiz::select('id')->where('course_id', $course->id)->get();
        $first_three_users = UserQuezGrade::with('user')
            ->whereIn('quiz_id', $quizzs)
            ->select('user_id', DB::raw('sum(user_grade) as grade'))
            ->groupBy('user_id')
            ->orderBy('grade', 'desc')
            ->take(3)
            ->get();
        $course['first_three_users'] = $first_three_users;
        foreach ($course->users as $i => $user) {
            if ($user->id == Auth::user('user')->id) {
                $course['logged_user_have_this_course'] = true;
            } else {
                $course['logged_user_have_this_course'] = false;
            }
        }

        return response()->json($course, 200);
    }
    public function singleCourseForTeacher($id)
    {
        $course = Course::with('users')->with('subject', function ($q) {
            return $q->with('teacher');
        })->find($id);
        $quizzs = Quiz::select('id')->where('course_id', $course->id)->get();
        $first_three_users = UserQuezGrade::with('user')
            ->whereIn('quiz_id', $quizzs)
            ->select('user_id', DB::raw('sum(user_grade) as grade'))
            ->groupBy('user_id')
            ->orderBy('grade', 'desc')
            ->take(3)
            ->get();
        $course['first_three_users'] = $first_three_users;
        return response()->json($course, 200);
    }
    public function singleTeacher($id)
    {
        $teacher = Teacher::with('subjects')->find($id);
        return response()->json($teacher, 200);
    }
    public function singleStudent($id)
    {
        $student = User::with('courses')->find($id);
        return response()->json($student, 200);
    }
    public function matterialsShow()
    {
        $matterials = SubjectMatterial::with('subject')->with('subject', function ($q) {
            return $q->with('teacher');
        })->get();
        return response()->json($matterials, 200);
    }
    public function matterialStore(Request $request)
    {
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
                return response()->json('matterial Stored', 200);
            }
        } catch (\Throwable $th) {
            return response()->json('some thing went wrong', 401);
        }
    }
    public function matterialUpdate(Request $request)
    {
        $matterial = SubjectMatterial::with('subject')->find($request->matterial_id);
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
                return response()->json('matterial updated', 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json('some thing went wrong', 401);
        }
    }
    public function matterialDelete($id)
    {
        try {
            $deleted = SubjectMatterial::find($id)->delete();
            if ($deleted) {
                return response()->json('matterial deleted', 200);
            }
        } catch (\Throwable $th) {
            return response()->json('some thing went wrong', 401);
        }
    }
    public function homeworkShow($course_id)
    {
        $now_date = Carbon::now('Africa/Cairo');
        $date = $now_date->toArray();
        $ActiveHomeworks = Homework::where('course_id', $course_id)->with('course')->with('course', function ($q) {
            return $q->with('subject')->with('subject', function ($qq) {
                return $qq->with('teacher');
            });
        })
            ->where('start_date', '<=', $date['year'] . '-' . $date['month'] . '-' . $date['day'])
            ->where('end_date', '>=', $date['year'] . '-' . $date['month'] . '-' . $date['day'])
            ->get();

        $InactiveHomeworks = Homework::where('course_id', $course_id)->with('course')->with('course', function ($q) {
            return $q->with('subject')->with('subject', function ($qq) {
                return $qq->with('teacher');
            });
        })
            ->where('end_date', '<=', $date['year'] . '-' . $date['month'] . '-' . $date['day'])
            ->get();


        return response()->json(['active_homework' => $ActiveHomeworks, 'inactive_homework' => $InactiveHomeworks], 200);
    }
    public function homeworkStore(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
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
                return response()->json('Homework Created ', 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json('some thing went wrong', 401);
        }
    }
    public function homeworkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'homework_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'src' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $homework = Homework::with('course')->find($request->homework_id);
        try {
            $stored = $homework->update([
                'course_id' => $request->course_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'src' => $request->src,
            ]);

            if ($stored) {
                return response()->json('Homework Updated ', 200);
            }
        } catch (\Throwable $th) {
            return response()->json('some thing went wrong', 401);
        }
    }
    public function homeworkDelete($id)
    {
        try {
            $deleted = Homework::find($id)->delete();
            if ($deleted) {
                return response()->json('Homework Deleted ', 200);
            }
        } catch (\Throwable $th) {
            return response()->json('some thing went wrong', 401);
        }
    }
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'text' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $message = Message::create(['course_id' => $request->course_id, 'text' => $request->text]);

            if ($message) {
                return response()->json('message sent ', 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json('some thing went wrong', 401);
        }
    }
    public function updateMessage(Request $request, $message_id)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'text' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $message = Message::find($message_id)->update(['course_id' => $request->course_id, 'text' => $request->text]);

            if ($message) {
                return response()->json('message updated ', 200);
            }
        } catch (\Throwable $th) {
            return response()->json('some thing went wrong', 401);
        }
    }
    public function deleteMessage($message_id)
    {
        try {
            $message = Message::find($message_id)->delete();
            return response()->json('message deleted ', 200);
        } catch (\Throwable $th) {
            return response()->json('some thing went wrong', 401);
        }
    }
    public function messages()
    {
        $courses_id = Course::select('id')->where(function ($q) {
            $q->with('users')->where('id', Auth::user('user')->id);
        })->get();
        $messages = Message::with('course')->with('course', function ($q) {
            return $q->with('subject');
        })->whereIn('course_id', $courses_id)->get();
        return response()->json(['messages' => $messages]);
    }
    public function givefeedback(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|numeric',
            'review' => 'required|string',
            'rate' => 'required|numeric|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $teacher = Teacher::find($request->teacher_id);
            $feedback = TeacherUserFeedback::where(['user_id' => Auth::user('user')->id, 'teacher_id' => $request->teacher_id])->get();
            if ($feedback) {
                $teacher->userFeedbacks()->detach(Auth::user('user')->id);
            }
            $teacher->userFeedbacks()->attach(Auth::user('user')->id, ['review' => $request->review, 'rate' => $request->rate]);
            $rates = TeacherUserFeedback::where('teacher_id', $teacher->id)->avg('rate');
            $teacher->update(['rate' => round($rates)]);
            return response()->json('feedback sent ', 200);
        } catch (\Throwable $th) {
            return $th;
            return response()->json('some thing went wrong', 401);
        }
    }
    public function todayCoursesList()
    {

        $d = new DateTime();
        $today = $d->format('l');
        // sunday,monday,tuesday,wednesday,thursday,saturday,'friday
        $sunday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'sunday')->orWhere('secondday', 'sunday');
            })
            ->get();
        $monday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'monday')->orWhere('secondday', 'monday');
            })
            ->get();
        $tuesday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'tuesday')->orWhere('secondday', 'tuesday');
            })
            ->get();
        $wednesday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'wednesday')->orWhere('secondday', 'wednesday');
            })
            ->get();
        $thursday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'thursday')->orWhere('secondday', 'thursday');
            })
            ->get();
        $saturday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'saturday')->orWhere('secondday', 'saturday');
            })
            ->get();
        $friday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'friday')->orWhere('secondday', 'friday');
            })
            ->get();



        $todaycourses = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user('user')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where('firstday', $today)
            ->orWhere('secondday', $today)
            ->get();
        return response()->json(['sunday' => $sunday, 'monday' => $monday, 'tuesday' => $tuesday, 'wednesday' => $wednesday, 'thursday' => $thursday, 'saturday' => $saturday, 'friday' => $friday, 'today' => $today, 'todaycourses' => $todaycourses]);
    }
    public function todayCoursesListForTeacher()
    {
        $d = new DateTime();
        $today = $d->format('l');
        // sunday,monday,tuesday,wednesday,thursday,saturday,'friday
        $sunday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'sunday')->orWhere('secondday', 'sunday');
            })
            ->get();
        $monday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'monday')->orWhere('secondday', 'monday');
            })
            ->get();
        $tuesday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'tuesday')->orWhere('secondday', 'tuesday');
            })
            ->get();
        $wednesday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'wednesday')->orWhere('secondday', 'wednesday');
            })
            ->get();
        $thursday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'thursday')->orWhere('secondday', 'thursday');
            })
            ->get();
        $saturday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'saturday')->orWhere('secondday', 'saturday');
            })
            ->get();
        $friday = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where(function ($q) {
                $q->where('firstday', 'friday')->orWhere('secondday', 'friday');
            })
            ->get();



        $todaycourses = Course::with(['subject' => function ($q) {
            $q->with('teacher');
        }])
            ->whereHas('subject', function ($q) {
                $q->where('teacher_id', Auth::user('teacher')->id);
            })
            ->whereDate('start_date', '<', Carbon::today())
            ->whereDate('end_date', '>', Carbon::today())
            ->where('firstday', $today)
            ->orWhere('secondday', $today)
            ->get();
        return response()->json(['sunday' => $sunday, 'monday' => $monday, 'tuesday' => $tuesday, 'wednesday' => $wednesday, 'thursday' => $thursday, 'saturday' => $saturday, 'friday' => $friday, 'today' => $today, 'todaycourses' => $todaycourses]);
    }
    public function getHomeWorks($course_id)
    {
        $homeworks = Homework::where('course_id', $course_id)->get();
    }
    public function userAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'status' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $userCourse =  UserCourse::where(['user_id' => $request->user_id, 'course_id' => $request->course_id])->first();
        try {
            if ($request->status == 'true') {
                $save_attend = $userCourse->update(['attendance_number' => $userCourse->attendance_number + 1, 'last_attend' => Carbon::now()]);
                return response()->json('user attend ', 200);
            } elseif ($request->status == 'false') {
                $save_absence = $userCourse->update(['absence_number' => $userCourse->absence_number + 1]);
                return response()->json('user absence ', 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json('some thing went wrong', 401);
        }
    }
    public function usersForAttendance($course_id)
    {
        try {
            $users =  UserCourse::with('user')->where(['course_id' => $course_id])->whereDate('updated_at', '!=', Carbon::today())->get();
            return response()->json(['users' => $users]);
        } catch (\Throwable $th) {
            return $th;
            return response()->json('some thing went wrong', 401);
        }
    }
    public function feedbacks()
    {
        try {
            $feedbacks = TeacherUserFeedback::with('teacher', 'user')->get();
            return view('admin.feedbacks.show', compact('feedbacks'));
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function topThree()
    {

        $first_three_users = UserQuezGrade::with('user')
            ->select('user_id', DB::raw('sum(user_grade) as grade'))
            ->groupBy('user_id')
            ->orderBy('grade', 'desc')
            ->take(3)
            ->get();
        $logged_user_grade = UserQuezGrade::with('user')
            ->where('user_id', Auth::user('user')->id)
            ->select('user_id', DB::raw('sum(user_grade) as grade'))
            ->groupBy('user_id')
            ->orderBy('grade', 'desc')
            ->get();
        return response()->json(['top_three_users' => $first_three_users, 'logged_user_grade' => $logged_user_grade]);
    }
    public function loggedUserPoints()
    {

        $logged_user_points = UserQuezGrade::with('user')
            ->where('user_id', Auth::user('user')->id)
            ->select('user_id', DB::raw('sum(user_grade) as grade'))
            ->groupBy('user_id')
            ->orderBy('grade', 'desc')
            ->get();
        return response()->json(['logged_user_points' => $logged_user_points]);
    }
}
