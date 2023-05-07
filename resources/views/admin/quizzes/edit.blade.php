@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Edit Quiz</h3>
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
                            <form method="POST" action="{{ route('admin.quiz.update', $quiz->id) }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="course">select Course</label>
                                    <select class="form-control" name="course_id" id="">
                                        @foreach ($courses as $course)
                                            <option {{ $quiz->course->id == $course->id ? 'selected' : '' }}
                                                value="{{ $course->id }}">{{ $course->subject->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" value="{{ $quiz->date }}" class="form-control"
                                        id="name" aria-describedby="date">
                                </div>
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="time" name="start_time" value="{{ $quiz->start_time }}"
                                        class="form-control" id="start_time" aria-describedby="start_time">
                                </div>
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="time" name="end_time" value="{{ $quiz->end_time }}" class="form-control"
                                        id="end_time" aria-describedby="end_time">
                                </div>

                                <div class="form-group">
                                    <label for="total_grade">Total Grade</label>
                                    <input type="number" name="total_grade" value="{{ $quiz->total_grade }}"
                                        class="form-control" id="total_grade" aria-describedby="total_grade">
                                </div>
                                <div class="form-group">
                                    <label for="details">details</label>
                                    <input type="text" name="details" value="{{ $quiz->details }}" class="form-control"
                                        id="details" aria-describedby="details">
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
