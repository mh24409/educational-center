@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Feedbacks</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
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
                                <th scope="col">Teacher</th>
                                <th scope="col">User</th>
                                <th scope="col">Review</th>
                                <th scope="col">Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedbacks as $index => $feedback)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $feedback->teacher->username }}</td>
                                    <td>{{ $feedback->user->username }}</td>
                                    <td>{{ $feedback->review }}</td>
                                    <td>{{ $feedback->rate }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection
