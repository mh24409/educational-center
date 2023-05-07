@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Teachers</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.teacher.create') }}">New Teacher</a>
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
                                <th scope="col">name</th>
                                <th scope="col">email</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $index => $teacher)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $teacher->username }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.teacher.edit', $teacher->id) }}"
                                            class="btn btn-sm btn-info">Edit</a>
                                        <a href="{{ route('admin.teacher.teacherVerifyEmail', $teacher->id) }}"
                                            class="btn btn-sm {{ $teacher->email_verified_at === null ? 'btn-success' : 'btn-danger' }}">
                                            {{ $teacher->email_verified_at === null ? 'Active' : 'InActive' }}</a>

                                        <a href="{{ route('admin.teacher.delete', $teacher->id) }}"
                                            class="btn btn-sm btn-danger">Delete</a>

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
