@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">MATTERIALS</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.matterial.create') }}"> New Matterial</a>
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
                                <th scope="col">subject</th>
                                <th scope="col">teacher</th>
                                <th scope="col">details</th>
                                <th scope="col">src</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matterials as $index => $matterial)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ Str::limit($matterial->name, 5, '......') }}</td>
                                    <td>{{ $matterial->subject->name }}</td>
                                    <td>{{ $matterial->subject->teacher->username }}</td>
                                    <td>{{ Str::limit($matterial->details, 10, '......') }}</td>
                                    <td>{{ Str::limit($matterial->src, 10, '......') }}</td>
                                    <td>
                                        <a href="{{ route('admin.matterial.edit', $matterial->id) }}"
                                            class="btn btn-sm btn-info">
                                            edit</a>
                                        <a href="{{ route('admin.matterial.delete', $matterial->id) }}"
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
