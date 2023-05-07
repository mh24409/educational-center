<?php

namespace Database\Seeders;

use DateTime;
use Carbon\Carbon;
use Faker\Factory;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\Homework;
use App\Models\QuizQuestion;
use App\Models\UserQuezGrade;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\UserQuestionAnswer;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        // admin
        \App\Models\Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('123456789'),
        ]);
        // level
        \App\Models\Level::create([
            'level_name' => 'first',
        ]);
        // default teacher
        \App\Models\Teacher::create([
            'username' => 'default teacher',
            'email' => 'teacher@teacher.teacher',
            'phone' => '01279783447',
            'about' => 'about default teacher',
            'school' => 'school for default teacher',
            'password' => Hash::make('123456789'),
            'birthdate' => Carbon::now('Africa/Cairo'),
            'image' => 'default.png',
        ]);
        // more teachers
        for ($i = 0; $i < 2; $i++) {
            \App\Models\Teacher::create([
                'username' => $faker->unique()->username,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->phoneNumber,
                'about' => 'about default teacher',
                'school' => 'school for default teacher',
                'password' => Hash::make('123456789'),
                'birthdate' => Carbon::now('Africa/Cairo'),
                'image' => 'default.png',
            ]);
        }
        // default user
        \App\Models\User::create([
            'username' => 'default user',
            'email' => 'user@user.user',
            'phone' => '01279783447',
            'level_id' => 1,
            'school' => 'school for default user',
            'password' => Hash::make('123456789'),
            'birthdate' => Carbon::now('Africa/Cairo'),
            'email_verified_at' => Carbon::now('Africa/Cairo'),
            'image' => 'default.png',
        ]);
        \App\Models\TeacherUserFeedback::create([
            'teacher_id' => 1,
            'user_id' => 1,
            'review' => 'this is default feedback',
            'rate' => 4,
        ]);
        // more users
        for ($i = 0; $i < 2; $i++) {
            $user =    \App\Models\User::create([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->unique()->phoneNumber,
                'level_id' => 1,
                'school' => 'school for default user',
                'password' => Hash::make('123456789'),
                'birthdate' => Carbon::now('Africa/Cairo'),
                'email_verified_at' => Carbon::now('Africa/Cairo'),
                'image' => 'default.png',
            ]);
            for ($q = 0; $q < 2; $q++) {
                \App\Models\TeacherUserFeedback::create([
                    'teacher_id' => ++$q,
                    'user_id' => $user->id,
                    'review' => 'this is default feedback',
                    'rate' => 4,
                ]);
            }
        }

        // subject & matterials & courses & user courses &quiz
        $s = new DateTime('now +3 day');
        $second_day = $s->format('l');

        $d = new DateTime();

        $now_day = $d->format('l');

        for ($i = 0; $i < 3; $i++) {
            $q = $i + 1;
            $subject = \App\Models\Subject::create([
                'name' => 'default subject',
                'level_id' => 1,
                'teacher_id' => 1,
                'details' => 'default subject details',
            ]);
            for ($i = 0; $i < 5; $i++) {
                \App\Models\SubjectMatterial::create([
                    'name' => $faker->name,
                    'subject_id' => $subject->id,
                    'src' => $faker->sentence(7),
                    'details' => $faker->sentence(15),
                ]);
            }
            $course =  \App\Models\Course::create([
                'details' => 'default subject',
                'subject_id' => $q,
                'image' => 'default.png',
                'no_of_students' => 45,
                'no_of_avilables' => 45,
                'firstday' => $now_day,
                'firstdaytime' => 'first',
                'secondday' => $second_day,
                'seconddaytime' => 'second',
                'start_date' => Carbon::now('Africa/Cairo')->subMonth(),
                'end_date' => Carbon::now('Africa/Cairo')->addMonth(),
                'status' => 1,
            ]);
            for ($i = 1; $i < 6; $i++) {
                $homework =    \App\Models\Homework::create([
                    'course_id' => $course->id,
                    'start_date' => Carbon::now('Africa/Cairo'),
                    'end_date' => Carbon::now('Africa/Cairo')->addDay(),
                    'src' => 'http://lllllllllllll',
                ]);
                \App\Models\Message::create([
                    'course_id' =>  $course->id,
                    'text' => 'message for course',
                ]);
                for ($ii = 0; $ii < 3; $ii++) {
                    $q = $ii + 1;
                    $user = User::find($q);
                    $homework->users()->attach($user->id, ['src' => 'homework' . $q . 'url']);
                }
            }

            $course->users()->attach(1, ['firstday' => $course->firstday, 'firstdaytime' => $course->firstdaytime, 'secondday' => $course->secondday, 'seconddaytime' => $course->seconddaytime, 'start_date' => $course->start_date, 'end_date' => $course->end_date, 'updated_at' => Carbon::now('Africa/Cairo')->subDays(3)]);
            $course->users()->attach(2, ['firstday' => $course->firstday, 'firstdaytime' => $course->firstdaytime, 'secondday' => $course->secondday, 'seconddaytime' => $course->seconddaytime, 'start_date' => $course->start_date, 'end_date' => $course->end_date, 'updated_at' => Carbon::now('Africa/Cairo')->subDays(3)]);
            $course->users()->attach(3, ['firstday' => $course->firstday, 'firstdaytime' => $course->firstdaytime, 'secondday' => $course->secondday, 'seconddaytime' => $course->seconddaytime, 'start_date' => $course->start_date, 'end_date' => $course->end_date, 'updated_at' => Carbon::now('Africa/Cairo')->subDays(3)]);
            $course->update(['no_of_avilables' => $course->no_of_avilables - 1]);
            $activeStart = carbon::now('Africa/Cairo')->toArray();
            $activeEnd = carbon::now('Africa/Cairo')->addHours(5)->toArray();
            $activeQuiz = \App\Models\Quiz::create([
                'course_id' => $course->id,
                'date' => carbon::now('Africa/Cairo'),
                'start_time' => $activeStart['hour'] . ':' . $activeStart['minute'] . ':' . $activeStart['second'],
                'end_time' => $activeEnd['hour'] . ':' . $activeEnd['minute'] . ':' . $activeEnd['second'],
                'total_grade' => random_int(20, 100),
                'status' => 'active',
                'details' => 'detailsdetailsdetailsdetailsdetailsdetails',
            ]);
            for ($i = 1; $i < 7; $i++) {
                \App\Models\QuizQuestion::create([
                    'quiz_id' => $activeQuiz->id,
                    'question' =>  $faker->sentence(15) . '?',
                    'choice_a' => 'choice 1 for this question',
                    'choice_b' => 'choice 2 for this question',
                    'choice_c' => 'choice 3 for this question',
                    'choice_d' => 'choice 4 for this question',
                    'correct_answer' => 'choice_a',
                    'grade' => random_int(20, 100) / 6,
                ]);
            }
            $inactiveStart = carbon::now('Africa/Cairo')->addDays(5)->toArray();
            $insactiveEnd = carbon::now('Africa/Cairo')->addDays(5)->addHours(6)->toArray();
            $inactiveQuiz = \App\Models\Quiz::create([
                'course_id' => $course->id,
                'date' => carbon::now('Africa/Cairo')->addDays(5),
                'start_time' => $inactiveStart['hour'] . ':' . $inactiveStart['minute'] . ':' . $inactiveStart['second'],
                'end_time' => $insactiveEnd['hour'] . ':' . $insactiveEnd['minute'] . ':' . $insactiveEnd['second'],
                'total_grade' => random_int(20, 100),
                'status' => 'inactive',
                'details' => 'detailsdetailsdetailsdetailsdetailsdetails',
            ]);
            for ($i = 1; $i < 7; $i++) {
                \App\Models\QuizQuestion::create([
                    'quiz_id' => $inactiveQuiz->id,
                    'question' => $faker->sentence(15) . '?',
                    'choice_a' => 'choice 1 for this question',
                    'choice_b' => 'choice 2 for this question',
                    'choice_c' => 'choice 3 for this question',
                    'choice_d' => 'choice 4 for this question',
                    'correct_answer' => 'choice_a',
                    'grade' => random_int(20, 100) / 6,
                ]);
            }
            $expiredStart = carbon::now('Africa/Cairo')->subDays(5)->toArray();
            $expiredEnd = carbon::now('Africa/Cairo')->subDays(5)->addHours(6)->toArray();
            $expiredQuiz = \App\Models\Quiz::create([
                'course_id' => $course->id,
                'date' => carbon::now('Africa/Cairo')->subDays(5),
                'start_time' => $expiredStart['hour'] . ':' . $expiredStart['minute'] . ':' . $expiredStart['second'],
                'end_time' => $expiredEnd['hour'] . ':' . $expiredEnd['minute'] . ':' . $expiredEnd['second'],
                'total_grade' => random_int(20, 100),
                'status' => 'expired',
                'details' => 'detailsdetailsdetailsdetailsdetailsdetails',
            ]);
            for ($i = 1; $i < 7; $i++) {
                $quiz_question = \App\Models\QuizQuestion::create([
                    'quiz_id' => $expiredQuiz->id,
                    'question' =>  $faker->sentence(15) . '?',
                    'choice_a' => 'choice 1 for this question',
                    'choice_b' => 'choice 2 for this question',
                    'choice_c' => 'choice 3 for this question',
                    'choice_d' => 'choice 4 for this question',
                    'correct_answer' => 'choice_a',
                    'grade' => random_int(20, 100) / 6,
                ]);

                $quiz = $expiredQuiz;
                for ($ii = 0; $ii < 3; $ii++) {
                    if ("choice_a" == $quiz_question->correct_answer) {
                        $stored = UserQuestionAnswer::create([
                            'quiz_questions_id' => $quiz_question->id,
                            'user_id' => $ii + 1,
                            'user_answer' => "choice_a",
                            'user_grade' => $quiz_question->grade,
                        ]);
                    } else {
                        $stored = UserQuestionAnswer::create([
                            'quiz_questions_id' => $quiz_question->id,
                            'user_id' =>  $ii + 1,
                            'user_answer' => "choice_a",
                            'user_grade' => 0,
                        ]);
                    }
                    if ($stored) {
                        $quiz_questions_ids = QuizQuestion::where('quiz_id', $quiz->id)->get('id');
                        $total_grade = $quiz->total_grade;
                        $sum_of_grades = UserQuestionAnswer::where('user_id', 1)->whereIn('quiz_questions_id', $quiz_questions_ids)->sum('user_grade');
                        $calc_User_grade = UserQuezGrade::updateOrCreate([
                            'user_id'   =>  $ii + 1,
                            'quiz_id'   => $quiz->id,
                        ], [
                            'user_grade'     => $sum_of_grades,
                        ]);
                    }
                }
            }
        }
        ///////////////////////////////////////////




    }
}
