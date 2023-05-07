@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">HomeWork</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.homework.create') }}"> New Homework</a>
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
                                <th scope="col">Course</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">src</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($homeworks as $index => $homework)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $homework->course->subject->name }}</td>
                                    <td>{{ $homework->course->subject->teacher->username }}</td>
                                    <td>{{ $homework->start_date }}</td>
                                    <td>{{ $homework->end_date }}</td>
                                    <td>{{ $homework->src }}</td>
                                    <td>
                                        <a href="{{ route('admin.homework.edit', $homework->id) }}"
                                            class="btn btn-sm btn-info">
                                            edit</a>
                                        <a href="{{ route('admin.homework.delete', $homework->id) }}"
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
