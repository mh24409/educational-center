@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">New Admin</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.admin.show') }}">Admin</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.admin.update', $admin->id) }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="name">name</label>
                                    <input type="text" name="name" value="{{ $admin->name }}" class="form-control"
                                        id="name" aria-describedby="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" name="email" value="{{ $admin->email }}" class="form-control"
                                        id="email" aria-describedby="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">password</label>
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control" id="password" aria-describedby="password">
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm"> confirm password</label>
                                    <input id="password-confirm" type="password" value="{{ old('password_confirmation') }}"
                                        class="form-control" name="password_confirmation"
                                        autocomplete="new-password">

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
