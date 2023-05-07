<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', 'HomeController@index')->name('home');

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Register
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');
Route::group(['prefix' => 'admin', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\HomeController::class, 'adminShow'])->name('admin.show');
    Route::get('create', [\App\Http\Controllers\Admin\HomeController::class, 'adminCreate'])->name('admin.create');
    Route::post('store', [\App\Http\Controllers\Admin\HomeController::class, 'adminStore'])->name('admin.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'adminEdit'])->name('admin.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'adminUpdate'])->name('admin.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'delete'])->name('admin.delete');
});
Route::group(['prefix' => 'teacher', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\TeacherController::class, 'teacherShow'])->name('teacher.show');
    Route::get('create', [\App\Http\Controllers\Admin\TeacherController::class, 'teacherCreate'])->name('teacher.create');
    Route::post('store', [\App\Http\Controllers\Admin\TeacherController::class, 'teacherStore'])->name('teacher.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'teacherEdit'])->name('teacher.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'teacherUpdate'])->name('teacher.update');
    Route::get('teacherVerifyEmail/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'teacherVerifyEmail'])->name('teacher.teacherVerifyEmail');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'delete'])->name('teacher.delete');
});

Route::group(['prefix' => 'user', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\UserController::class, 'userShow'])->name('user.show');
    Route::get('create', [\App\Http\Controllers\Admin\UserController::class, 'userCreate'])->name('user.create');
    Route::post('store', [\App\Http\Controllers\Admin\UserController::class, 'userStore'])->name('user.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\UserController::class, 'userEdit'])->name('user.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\UserController::class, 'userUpdate'])->name('user.update');
    Route::get('userVerifyEmail/{id}', [\App\Http\Controllers\Admin\UserController::class, 'userVerifyEmail'])->name('user.userVerifyEmail');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\UserController::class, 'delete'])->name('user.delete');
});

Route::group(['prefix' => 'subject', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\SubjectController::class, 'subjectShow'])->name('subject.show');
    Route::get('create', [\App\Http\Controllers\Admin\SubjectController::class, 'subjectCreate'])->name('subject.create');
    Route::post('store', [\App\Http\Controllers\Admin\SubjectController::class, 'subjectStore'])->name('subject.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\SubjectController::class, 'subjectEdit'])->name('subject.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\SubjectController::class, 'subjectUpdate'])->name('subject.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\SubjectController::class, 'delete'])->name('subject.delete');
});
Route::group(['prefix' => 'level', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\LevelController::class, 'levelShow'])->name('level.show');
    Route::get('create', [\App\Http\Controllers\Admin\LevelController::class, 'levelCreate'])->name('level.create');
    Route::post('store', [\App\Http\Controllers\Admin\LevelController::class, 'levelStore'])->name('level.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\LevelController::class, 'levelEdit'])->name('level.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\LevelController::class, 'levelUpdate'])->name('level.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\LevelController::class, 'delete'])->name('level.delete');
});

Route::group(['prefix' => 'course', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\UserCoursesController::class, 'show'])->name('course.show');
    Route::get('create', [\App\Http\Controllers\Admin\UserCoursesController::class, 'create'])->name('course.create');
    Route::post('store', [\App\Http\Controllers\Admin\UserCoursesController::class, 'store'])->name('course.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\UserCoursesController::class, 'edit'])->name('course.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\UserCoursesController::class, 'update'])->name('course.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\UserCoursesController::class, 'delete'])->name('course.delete');
});
Route::group(['prefix' => 'matterial', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\MatterialController::class, 'show'])->name('matterial.show');
    Route::get('create', [\App\Http\Controllers\Admin\MatterialController::class, 'create'])->name('matterial.create');
    Route::post('store', [\App\Http\Controllers\Admin\MatterialController::class, 'store'])->name('matterial.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\MatterialController::class, 'edit'])->name('matterial.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\MatterialController::class, 'update'])->name('matterial.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\MatterialController::class, 'delete'])->name('matterial.delete');
});

Route::group(['prefix' => 'quiz', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\QuizController::class, 'show'])->name('quiz.show');
    Route::get('create', [\App\Http\Controllers\Admin\QuizController::class, 'create'])->name('quiz.create');
    Route::post('store', [\App\Http\Controllers\Admin\QuizController::class, 'store'])->name('quiz.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'edit'])->name('quiz.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'update'])->name('quiz.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'adminDelete'])->name('quiz.adminDelete');
    Route::get('adminAddQuestionToQuiz/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'adminAddQuestionToQuiz'])->name('quiz.adminAddQuestionToQuiz');
    Route::post('adminStoreQuestionToQuiz', [\App\Http\Controllers\Admin\QuizController::class, 'adminStoreQuestionToQuiz'])->name('quiz.adminStoreQuestionToQuiz');

    Route::get('editQuizQuestion/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'editQuizQuestion'])->name('quiz.editQuizQuestion');
    Route::post('updateQuizQuestion/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'updateQuizQuestion'])->name('quiz.updateQuizQuestion');

    Route::get('showSingleQuestion/{id}', [\App\Http\Controllers\Admin\QuizController::class, 'showSingleQuestion'])->name('quiz.showSingleQuestion');
});

Route::group(['prefix' => 'homework', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\HomeworkController::class, 'show'])->name('homework.show');
    Route::get('create', [\App\Http\Controllers\Admin\HomeworkController::class, 'create'])->name('homework.create');
    Route::post('store', [\App\Http\Controllers\Admin\HomeworkController::class, 'store'])->name('homework.store');
    Route::get('edit/{id}', [\App\Http\Controllers\Admin\HomeworkController::class, 'edit'])->name('homework.edit');
    Route::post('update/{id}', [\App\Http\Controllers\Admin\HomeworkController::class, 'update'])->name('homework.update');
    Route::get('delete/{id}', [\App\Http\Controllers\Admin\HomeworkController::class, 'delete'])->name('homework.delete');
});
Route::group(['prefix' => 'feedback', 'middleware' => 'admin.auth:admin'], function () {
    Route::get('show', [\App\Http\Controllers\Admin\HomeController::class, 'feedbacks'])->name('feedback.show');
});
