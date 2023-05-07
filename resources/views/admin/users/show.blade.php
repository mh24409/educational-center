@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">STUDENTS</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.user.create') }}"> New Student</a>
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
                            @foreach ($users as $index => $user)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-info">
                                            edit</a>
                                        <a href="{{ route('admin.user.userVerifyEmail', $user->id) }}"
                                            class="btn btn-sm {{ $user->email_verified_at === null ? 'btn-success' : 'btn-danger' }}">
                                            {{ $user->email_verified_at === null ? 'Active' : 'InActive' }}</a>
                                        <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-sm btn-danger">
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
