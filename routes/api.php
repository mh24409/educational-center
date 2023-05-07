<?php

use Carbon\Carbon;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuizController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function (Request $request) {
    $q = Quiz::first();
    $a = Carbon::parse($q->start_time);
    return $a->second;
});

Route::post('teacher/login', [\App\Http\Controllers\Api\AuthController::class, 'teacherLogin'])->name('teacherLogin');
Route::post('teacher/register', [\App\Http\Controllers\Api\AuthController::class, 'teacherRegister'])->name('teacherRegister');
Route::post('teacher/teacherResetPassword', [\App\Http\Controllers\Api\AuthController::class, 'teacherResetPassword'])->name('teacherResetPassword');
Route::group(['prefix' => 'teacher', 'middleware' => ['auth:teacher-api', 'scopes:teacher']], function () {
    Route::get('logout', [\App\Http\Controllers\Api\AuthController::class, 'teacherLogout'])->name('teacherLogout');
    Route::get('profile', [\App\Http\Controllers\Api\AuthController::class, 'teacherProfile']);
    Route::post('update/profile', [\App\Http\Controllers\Api\AuthController::class, 'teacherUpdateProfile']);
    Route::get('levels', [\App\Http\Controllers\Admin\HomeController::class, 'levels']);
    Route::get('subjects', [\App\Http\Controllers\Admin\HomeController::class, 'subjectsForTeacher']);
    Route::get('teachers', [\App\Http\Controllers\Admin\HomeController::class, 'teachers']);
    Route::get('courses', [\App\Http\Controllers\Admin\HomeController::class, 'coursesForTeacher']);
    Route::get('students', [\App\Http\Controllers\Admin\HomeController::class, 'students']);
    Route::get('subject/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleSubject']);
    Route::get('teacher/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleTeacher']);
    Route::get('course/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleCourseForTeacher']);
    Route::get('student/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleStudent']);
    Route::post('createQuiz', [\App\Http\Controllers\Admin\QuizController::class, 'createQuiz']);
    Route::post('addQuestionToQuiz', [\App\Http\Controllers\Admin\QuizController::class, 'addQuestionToQuiz']);
    Route::get('quizzesForTeacher', [\App\Http\Controllers\Admin\QuizController::class, 'quizzesForTeacher']);
    Route::get('questionsOfQuiz/{quiz_id}', [\App\Http\Controllers\Admin\QuizController::class, 'questionsOfQuiz']);
    Route::get('matterials/{subject_id}', [\App\Http\Controllers\Admin\HomeController::class, 'matterialsShow'])->name('matterial.show');
    Route::post('matterial/store', [\App\Http\Controllers\Admin\HomeController::class, 'matterialStore'])->name('matterial.store');
    Route::post('matterial/update', [\App\Http\Controllers\Admin\HomeController::class, 'matterialUpdate'])->name('matterial.update');
    Route::get('matterial/delete/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'matterialDelete'])->name('matterial.delete');
    Route::get('homeworks/{course_id}', [\App\Http\Controllers\Admin\HomeController::class, 'homeworkShow'])->name('homework.show');
    Route::post('homework/store', [\App\Http\Controllers\Admin\HomeController::class, 'homeworkStore'])->name('homework.store');
    Route::post('homework/update', [\App\Http\Controllers\Admin\HomeController::class, 'homeworkUpdate'])->name('homework.update');
    Route::get('homework/delete/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'homeworkDelete'])->name('homework.delete');
    Route::post('sendMessage', [\App\Http\Controllers\Admin\HomeController::class, 'sendMessage']);
    Route::post('updateMessage/{message_id}', [\App\Http\Controllers\Admin\HomeController::class, 'updateMessage']);
    Route::get('deleteMessage/{message_id}', [\App\Http\Controllers\Admin\HomeController::class, 'deleteMessage']);
    Route::get('usersForAttendance/{course_id}', [\App\Http\Controllers\Admin\HomeController::class, 'usersForAttendance']);
    Route::post('userAttendance', [\App\Http\Controllers\Admin\HomeController::class, 'userAttendance']);
    Route::get('todayCoursesListForTeacher', [\App\Http\Controllers\Admin\HomeController::class, 'todayCoursesListForTeacher']);
});

// studens routes

Route::post('user/login', [\App\Http\Controllers\Api\AuthController::class, 'userLogin'])->name('userLogin');
Route::post('user/register', [\App\Http\Controllers\Api\AuthController::class, 'userRegister'])->name('userRegister');
Route::post('user/userResetPassword', [\App\Http\Controllers\Api\AuthController::class, 'userResetPassword'])->name('userResetPassword');
Route::get('user/levels', [\App\Http\Controllers\Admin\HomeController::class, 'levels']);
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    Route::get('logout', [\App\Http\Controllers\Api\AuthController::class, 'userLogout'])->name('userLogout');
    Route::get('profile', [\App\Http\Controllers\Api\AuthController::class, 'userProfile']);
    Route::post('update/profile', [\App\Http\Controllers\Api\AuthController::class, 'userUpdateProfile']);
    Route::get('subjects', [\App\Http\Controllers\Admin\HomeController::class, 'subjectsForUser']);
    Route::get('teachers', [\App\Http\Controllers\Admin\HomeController::class, 'teachers']);
    Route::get('courses', [\App\Http\Controllers\Admin\HomeController::class, 'courses']);
    Route::get('students', [\App\Http\Controllers\Admin\HomeController::class, 'students']);
    Route::get('subject/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleSubject']);
    Route::get('teacher/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleTeacher']);
    Route::get('course/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleCourse']);
    Route::get('student/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'singleStudent']);
    Route::post('enrolltocourse', [\App\Http\Controllers\Admin\UserCoursesController::class, 'enrollToCourse'])->name('course.enrollToCourse');
    Route::post('disenrolltocourse', [\App\Http\Controllers\Admin\UserCoursesController::class, 'disenrollToCourse'])->name('course.disenrollToCourse');
    Route::post('userAnswerQuestion', [\App\Http\Controllers\Admin\QuizController::class, 'userAnswerQuestion']);
    Route::get('quizzesForUser/{course_id}', [\App\Http\Controllers\Admin\QuizController::class, 'quizzesForUser']);
    Route::get('questionsOfQuiz/{quiz_id}', [\App\Http\Controllers\Admin\QuizController::class, 'questionsOfQuiz']);
    Route::post('studentAnswerHomework', [\App\Http\Controllers\Admin\HomeworkController::class, 'studentAnswerHomework']);
    Route::get('homeworks/{course_id}', [\App\Http\Controllers\Admin\HomeController::class, 'homeworkShow'])->name('homework.show');
    Route::get('messages', [\App\Http\Controllers\Admin\HomeController::class, 'messages']);
    Route::post('givefeedback', [\App\Http\Controllers\Admin\HomeController::class, 'givefeedback']);
    Route::get('todayCoursesList', [\App\Http\Controllers\Admin\HomeController::class, 'todayCoursesList']);
    Route::get('courseQuizzesTotalGrade/{course_id}', [\App\Http\Controllers\Admin\QuizController::class, 'courseQuizzesTotalGrade']);
    Route::get('loggedUserPoints', [\App\Http\Controllers\Admin\QuizController::class, 'loggedUserPoints']);
    Route::get('topThree', [\App\Http\Controllers\Admin\HomeController::class, 'topThree']);
});
