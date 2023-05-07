@extends('Admin.layouts.master')
<style>
    .box {
        width: 350px;
        height: 170px;
        border-radius: 50px;
        padding: 0px;
        position: relative;
        margin-bottom: 20px
    }

    .box-footer {
        position: absolute;
        bottom: 0px;
        right: 0px;
        padding: 0px;
        width: 100%;
        height: 40px;
        overflow: hidden;
        color: white;
        border-top: 1px solid rgba(128, 128, 128, 0.271);
        text-decoration: none;
    }

    .box-footer:hover {
        color: black;
        text-decoration: none
    }

    .title {
        position: absolute;
        bottom: 51px;
        left: 33px;
        font-size: 25px;
        color: white;
    }

    .number {
        position: absolute;
        top: -2px;
        left: 7px;
        font-size: 60px;
        color: white;
    }

    .icon {
        position: absolute;
        top: -46px;
        right: 16px;
        font-size: 154px;
        color: white;
    }
</style>
@section('wrapper')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(51,153,255)">
                                <div class="title">
                                    Levels
                                </div>
                                <div class="number">
                                    {{ App\Models\Level::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.level.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(39, 137, 234)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color:rgb(249,177,22)">
                                <div class="title">
                                    Teachers
                                </div>
                                <div class="number">
                                    {{ App\Models\Teacher::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.teacher.show') }}" class="box-footer text-center"
                                    style="font-size: 25px ; background-color: rgb(229, 162, 18)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(229,83,82)">
                                <div class="title">
                                    Students
                                </div>
                                <div class="number">
                                    {{ App\Models\User::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.user.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(212, 66, 66)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(254,169,132)">
                                <div class="title">
                                    Subjects
                                </div>
                                <div class="number">
                                    {{ App\Models\Subject::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.subject.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(242, 152, 113)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(93,219,200)">
                                <div class="title">
                                    Courses
                                </div>
                                <div class="number">
                                    {{ App\Models\Course::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.course.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(76, 194, 176)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(253,149,100)">
                                <div class="title">
                                    Matterials
                                </div>
                                <div class="number">
                                    {{ App\Models\SubjectMatterial::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.matterial.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(228, 127, 81)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(0,48,84)">
                                <div class="title">
                                    Homework
                                </div>
                                <div class="number">
                                    {{ App\Models\Homework::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.homework.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(3, 37, 62)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(47, 178, 95)">
                                <div class="title">
                                    Quizzes
                                </div>
                                <div class="number">
                                    {{ App\Models\Quiz::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="{{ route('admin.quiz.show') }}" class="box-footer text-center"
                                    style="font-size: 25px;background-color:rgb(28, 133, 67)"> SEE MORE</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="box" style="background-color: rgb(7, 32, 16)">
                                <div class="title">
                                    Admins
                                </div>
                                <div class="number">
                                    {{ App\Models\Admin::count() }}
                                </div>
                                <div class="icon">
                                    <span class="mdi mdi-account"></span>
                                </div>
                                <a href="" class="box-footer text-center"
                                    style="font-size: 25px;background-color: rgb(3, 20, 9)"> SEE MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
