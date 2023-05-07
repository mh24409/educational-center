@extends('admin.layouts.master')
<style>
    .question {
        margin-top: 25px !important;
        border: solid;
        border-radius: 10px;
        position: relative;
    }

    .editbtn {
        background-color: unset;
        border: unset;
        font-size: 30px;
        position: absolute;
        right: 15px;
        top: 5px;
    }
</style>
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Quizzes</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.quiz.show') }}">Quizzes</a>
                </div>
            </div>

        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12 text-center" style="position: relative">
                            <h3 class="text-uppercase" style="font-size: 35px">{{ $quiz->course->subject->name }}</h3>
                            <a style="right:30% !important" href="{{ route('admin.quiz.edit', $quiz->id) }}" class="editbtn">
                                <span class="mdi mdi-tooltip-edit"></span> </a>
                        </div>
                        <div class="col-md-12 d-flex justify-content-around mt-4">
                            <div> <strong>Teacher : </strong> {{ $quiz->course->subject->teacher->username }}</div>
                            <div><strong>Date : </strong> {{ $quiz->date }}</div>
                            <div> <strong>Start Time : </strong>{{ $quiz->start_time }}</div>
                            <div> <strong>End Time : </strong> {{ $quiz->end_time }}</div>
                        </div>
                        @foreach ($quiz->questions as $question)
                            <div class="col-md-6">
                                <div class="question">
                                    <a href="{{ route('admin.quiz.editQuizQuestion', $question->id) }}" class="editbtn">
                                        <span class="mdi mdi-tooltip-edit"></span> </a>
                                    <div class="text-center "
                                        style="padding: 30px 0px !important ; font-size: 25px ; font-weight: bold">
                                        {{ $question->question }}
                                    </div>
                                    <div class="text-center">
                                        <p
                                            class="{{ $question->correct_answer == 'choice_a' ? 'text-success font-bold' : '' }}">
                                            a ) {{ $question->choice_a }} </p>
                                        <p
                                            class="{{ $question->correct_answer == 'choice_b' ? 'text-success font-bold' : '' }}">
                                            b ) {{ $question->choice_d }} </p>
                                        <p
                                            class="{{ $question->correct_answer == 'choice_c' ? 'text-success font-bold' : '' }}">
                                            c ) {{ $question->choice_c }} </p>
                                        <p
                                            class="{{ $question->correct_answer == 'choice_d' ? 'text-success font-bold' : '' }}">
                                            d ) {{ $question->choice_d }} </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
