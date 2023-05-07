@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Courses</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.course.create') }}">New Course</a>
                </div>
            </div>

        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">First Day</th>
                                <th scope="col">First Day Time</th>
                                <th scope="col">Second Day</th>
                                <th scope="col">Second Day Time</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Students</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $index => $course)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $course->subject->name }}</td>
                                    <td>{{ $course->subject->teacher->username }}</td>
                                    <td>{{ $course->firstday }}</td>
                                    <td>{{ $course->firstdaytime }}</td>
                                    <td>{{ $course->secondday }}</td>
                                    <td>{{ $course->seconddaytime }}</td>
                                    <td>{{ $course->start_date }}</td>
                                    <td>{{ $course->end_date }}</td>
                                    <td>{{ $course->users_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.course.edit', $course->id) }}"
                                            class="btn btn-sm btn-info">
                                            edit</a>
                                        <a href="{{ route('admin.course.delete', $course->id) }}"
                                            class="btn btn-sm btn-danger">
                                            delete</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
