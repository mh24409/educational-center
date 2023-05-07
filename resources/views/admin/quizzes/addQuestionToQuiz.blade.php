@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">New Quiz</h3>
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
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.quiz.adminStoreQuestionToQuiz') }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <input type="number" value="{{ $quiz_id }}" name="quiz_id" hidden>
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <input type="text" name="question" value="{{ old('question') }}" class="form-control"
                                        id="question" aria-describedby="question">
                                </div>
                                <div class="form-group">
                                    <label for="choice_a">Choice A</label>
                                    <input type="text" name="choice_a" value="{{ old('choice_a') }}" class="form-control"
                                        id="choice_a" aria-describedby="choice_a">
                                </div>
                                <div class="form-group">
                                    <label for="choice_b">Choice B</label>
                                    <input type="text" name="choice_b" value="{{ old('choice_b') }}" class="form-control"
                                        id="choice_b" aria-describedby="choice_b">
                                </div>
                                <div class="form-group">
                                    <label for="choice_c">Choice C</label>
                                    <input type="text" name="choice_c" value="{{ old('choice_c') }}" class="form-control"
                                        id="choice_c" aria-describedby="choice_c">
                                </div>
                                <div class="form-group">
                                    <label for="choice_d">Choice D</label>
                                    <input type="text" name="choice_d" value="{{ old('choice_d') }}" class="form-control"
                                        id="choice_d" aria-describedby="choice_d">
                                </div>
                                <div class="form-group">
                                    <label for="correct_answer">Correct Choice</label>
                                    <select class="form-control" name="correct_answer" id="correct_answer">
                                        <option value="choice_a">Choice A</option>
                                        <option value="choice_b">Choice B</option>
                                        <option value="choice_c">Choice C</option>
                                        <option value="choice_d">Choice D</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="grade">Grade</label>
                                    <input type="number" name="grade" value="{{ old('grade') }}" class="form-control"
                                        id="grade" aria-describedby="grade">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
