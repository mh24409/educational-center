@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">New Homework</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.homework.show') }}">Homeworks</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.homework.update', $homework->id) }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="course">Course</label>
                                    <select class="form-control" name="course_id" id="course">
                                        <option>Select Course </option>
                                        @foreach ($courses as $course)
                                            <option {{ $homework->course_id == $course->id ? 'selected' : '' }}
                                                value="{{ $course->id }}">{{ $course->subject->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" value="{{ $homework->start_date }}"
                                        class="form-control" id="start_date" aria-describedby="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" value="{{ $homework->end_date }}"
                                        class="form-control" id="end_date" aria-describedby="end_date">
                                </div>
                                <div class="form-group">
                                    <label for="src">SRC</label>
                                    <input type="text" name="src" value="{{ $homework->src }}" class="form-control"
                                        id="details" aria-describedby="src">
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
