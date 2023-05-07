<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\UserQuezGrade;
use Illuminate\Validation\Rule;
use App\Models\UserQuestionAnswer;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show()
    {
        $quizzes = Quiz::with('course')->with('course', function ($q) {
            return $q->with('subject');
        })->get();
        return view('admin.quizzes.show', compact('quizzes'));
    }
    public function create()
    {
        $courses = Course::with('subject')->get();
        return view('admin.quizzes.create', compact('courses'));
    }
    public function store(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'course_id' => 'required|numeric',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:time_start',
            'total_grade' => 'required|numeric',
            'details' => 'required',
        ]);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()->all()]);
        // }
        try {
            $stored = Quiz::create([
                'course_id' => $request->course_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total_grade' => $request->total_grade,
                'details' => $request->details,
            ]);

            if ($stored) {
                session()->flash('success', 'Quiz added successfuly');
                return redirect()->route('admin.quiz.show');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.quiz.show');
        }
    }
    public function createQuiz(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:time_start',
            'total_grade' => 'required|numeric',
            'details' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $stored = Quiz::create([
                'course_id' => $request->course_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total_grade' => $request->total_grade,
                'details' => $request->details,
            ])->id;
            $quis_id = $stored;
            if ($stored) {
                return response()->json($quis_id, 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['error' => ['some thing wen wrong please try again later.']], 200);
        }
    }
    public function adminAddQuestionToQuiz($id)
    {
        $quiz_id = $id;
        return view('admin.quizzes.addQuestionToQuiz', compact('quiz_id'));
    }
    public function adminStoreQuestionToQuiz(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'quiz_id' => 'required|numeric',
            'question' => 'required|string',
            'choice_a' => 'required|string',
            'choice_b' => 'required|string',
            'choice_c' => 'required|string',
            'choice_d' => 'required|string',
            'correct_answer' => 'required|in:choice_a,choice_b,choice_c,choice_d',
            'grade' => 'required',
        ]);
        try {
            $stored = QuizQuestion::create([
                'quiz_id' => $request->quiz_id,
                'question' => $request->question,
                'choice_a' => $request->choice_a,
                'choice_b' => $request->choice_b,
                'choice_c' => $request->choice_c,
                'choice_d' => $request->choice_d,
                'correct_answer' => $request->correct_answer,
                'grade' => $request->grade,
            ]);

            if ($stored) {
                session()->flash('success', 'question added successfuly');
                return redirect()->route('admin.quiz.show');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.quiz.show');
        }
    }
    public function showSingleQuestion($id)
    {
        $quiz = Quiz::with('questions', 'course')->with('course', function ($q) {
            return $q->with('subject', function ($qq) {
                return $qq->with('teacher');
            });
        })->find($id);
        return view('admin.quizzes.showSingleQuiz', compact('quiz'));
    }
    public function addQuestionToQuiz(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required|numeric',
            'question' => 'required|string',
            'choice_a' => 'required|string',
            'choice_b' => 'required|string',
            'choice_c' => 'required|string',
            'choice_d' => 'required|string',
            'correct_answer' => 'required|in:choice_a,choice_b,choice_c,choice_d',
            'grade' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $stored = QuizQuestion::create([
                'quiz_id' => $request->quiz_id,
                'question' => $request->question,
                'choice_a' => $request->choice_a,
                'choice_b' => $request->choice_b,
                'choice_c' => $request->choice_c,
                'choice_d' => $request->choice_d,
                'correct_answer' => $request->correct_answer,
                'grade' => $request->grade,
            ]);

            if ($stored) {
                return response()->json(['success' => ['Quiz created successfuly.']], 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['error' => ['some thing wen wrong please try again later.']], 200);
        }
    }
    public function userAnswerQuestion(Request $request)
    {

        // return $request;
        $user = Auth::user('user');
        $validator = Validator::make($request->all(), [
            'quiz_questions_id' => 'required|numeric|' . Rule::unique('user_question_answers')->where(function ($query) use ($request, $user) {
                return $query->where('quiz_questions_id', $request->quiz_questions_id)
                    ->where('user_id', $user->id);
            }),
            'user_answer' => 'in:choice_a,choice_b,choice_c,choice_d',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $quiz_question = QuizQuestion::find($request->quiz_questions_id);
            $quiz = Quiz::find($quiz_question->quiz_id);
            if ($request->user_answer && $request->user_answer == $quiz_question->correct_answer) {
                $stored = UserQuestionAnswer::create([
                    'quiz_questions_id' => $request->quiz_questions_id,
                    'user_id' => Auth::user('user')->id,
                    'user_answer' => $request->user_answer,
                    'user_grade' => $quiz_question->grade,
                ]);
            } else {
                $stored = UserQuestionAnswer::create([
                    'quiz_questions_id' => $request->quiz_questions_id,
                    'user_id' => Auth::user('user')->id,
                    'user_grade' => 0,
                ]);
            }
            if ($stored) {
                $quiz = Quiz::find($quiz_question->quiz_id);
                $quiz_questions_ids = QuizQuestion::where('quiz_id', $quiz->id)->get('id');
                $total_grade = $quiz->total_grade;
                $sum_of_grades = UserQuestionAnswer::where('user_id', Auth::user('user')->id)->whereIn('quiz_questions_id', $quiz_questions_ids)->sum('user_grade');
                $calc_User_grade = UserQuezGrade::updateOrCreate([
                    'user_id'   => Auth::user('user')->id,
                    'quiz_id'   => $quiz->id,
                ], [
                    'user_grade'     => $sum_of_grades,
                ]);
                return response()->json(['success' => ['question answered successfuly.']], 200);
            }
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['error' => ['some thing wen wrong please try again later.']], 200);
        }
    }
    public function questionsOfQuiz($quiz_id)
    {
        return $questions = QuizQuestion::where('quiz_id', $quiz_id)->get();
        return response()->json($questions, 200);
    }
    public function quizzesForUser($course_id)
    {
        return $quizzes = Quiz::where('course_id', $course_id)->with('user_grade', function ($q) {
            return $q->where('user_id', Auth::user('user')->id);
        })->get();
        return response()->json($quizzes, 200);
    }
    public function courseQuizzesTotalGrade($course_id)
    {
        $quizzesId = Quiz::select('id')->where('course_id', $course_id)->get();
        $quizzesTotalGrade = UserQuezGrade::whereIn('quiz_id', $quizzesId)->where('user_id', Auth::user('user')->id)->sum('user_grade');
        return response()->json(['user_total_grade' => $quizzesTotalGrade], 200);
    }
    public function loggedUserPoints()
    {
        // $quizzesId = Quiz::select('id')->where('course_id', $course_id)->get();
        $points = UserQuezGrade::where('user_id', Auth::user('user')->id)->sum('user_grade');
        return response()->json(['points' => $points], 200);
    }
    public function quizzesForTeacher()
    {
        $subjects = Subject::select('id')->where('teacher_id', Auth::user('teacher')->id)->get();
        $coursesID = Course::select('id')->whereIn('subject_id', $subjects)->get();
        $quizzes = Quiz::with('course')->whereIn('course_id', $coursesID)->get();
        return response()->json($quizzes, 200);
    }
    public function edit($id)
    {
        $courses = Course::get();
        $quiz = Quiz::with('course')->with('course', function ($q) {
            return $q->with('subject');
        })->find($id);
        return view('admin.quizzes.edit', compact('quiz', 'courses'));
    }
    public function update(Request $request, $id)
    {
        // return $request;
        $quiz = Quiz::find($id);
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|numeric',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:time_start',
            'total_grade' => 'required|numeric',
            'details' => 'required',
        ]);
        try {
            $stored = $quiz->update([
                'course_id' => $request->course_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total_grade' => $request->total_grade,
                'details' => $request->details,
            ]);

            if ($stored) {
                session()->flash('success', 'Quiz updated successfuly');
                return redirect()->route('admin.quiz.show');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.quiz.show');
        }
    }
    public function adminDelete($id)
    {
        try {
            $quiz = Quiz::find($id)->delete();
            if ($quiz) {
                QuizQuestion::where('quiz_id', $id)->delete();
            }
            session()->flash('success', 'Quiz deleted successfuly');
            return redirect()->route('admin.quiz.show');
        } catch (\Throwable $th) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.quiz.show');
        }
    }
    public function delete($id)
    {
        try {
            $quiz = Quiz::find($id)->delete();
            if ($quiz) {
                QuizQuestion::where('quiz_id', $id)->delete();
            }
            return response()->json(['success' => ['Quiz deleted successfuly.']], 200);
        } catch (\Throwable $th) {

            return response()->json(['error' => ['sorry , some thing went wrong  . try later']], 200);
        }
    }
    public function editQuizQuestion($id)
    {
        $question = QuizQuestion::find($id);
        return view('admin.quizzes.editQuizQuestion', compact('question'));
    }
    public function updateQuizQuestion(Request $request, $id)
    {

        $validated = $request->validate([
            'question' => 'required|string',
            'choice_a' => 'required|string',
            'choice_b' => 'required|string',
            'choice_c' => 'required|string',
            'choice_d' => 'required|string',
            'correct_answer' => 'required|in:choice_a,choice_b,choice_c,choice_d',
            'grade' => 'required',
        ]);
        try {
            $que = QuizQuestion::find($id);
            $stored = $que->update([
                'question' => $request->question,
                'choice_a' => $request->choice_a,
                'choice_b' => $request->choice_b,
                'choice_c' => $request->choice_c,
                'choice_d' => $request->choice_d,
                'correct_answer' => $request->correct_answer,
                'grade' => $request->grade,
            ]);

            if ($stored) {
                session()->flash('success', 'question updated successfuly');
                return redirect()->route('admin.quiz.showSingleQuestion', $que->quiz_id);
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'sorry , some thing went wrong  . try later');
            return redirect()->route('admin.quiz.showSingleQuestion', $que->quiz_id);
        }
    }
}
