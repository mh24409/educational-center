@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Levels</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.level.create') }}"> New Level</a>
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
                                <th scope="col">Level Name</th>
                                <th scope="col">Students No.</th>
                                <th scope="col">Supjects No.</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $index => $level)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $level->level_name }}</td>
                                    <td>{{ $level->users_count }}</td>
                                    <td>{{ $level->subjects_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.level.delete', $level->id) }}"
                                            class="btn btn-sm btn-danger">
                                            delete</a>
                                        <a href="{{ route('admin.level.edit', $level->id) }}" class="btn btn-sm btn-info">
                                            edit</a>
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
