@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">New Teacher</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.teacher.show') }}"> Teachers</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.teacher.store') }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="username">username</label>
                                    <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                        id="username" aria-describedby="username">
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                        id="email" aria-describedby="email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">phone</label>
                                    <input type="number" name="phone" value="{{ old('phone') }}" class="form-control"
                                        id="phone" aria-describedby="phone">
                                </div>
                                <div class="form-group">
                                    <label for="school">school</label>
                                    <input type="text" name="school" value="{{ old('school') }}" class="form-control"
                                        id="school" aria-describedby="school">
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">birthdate</label>
                                    <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                                        class="form-control" id="birthdate" aria-describedby="birthdate">
                                </div>
                                <div class="form-group">
                                    <label for="about">about</label>
                                    <input type="text" name="about" value="{{ old('about') }}" class="form-control"
                                        id="about" aria-describedby="about">
                                </div>
                                <div class="form-group">
                                    <label for="password">password</label>
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control" id="password" aria-describedby="password">
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm"> confirm password</label>
                                    <input id="password-confirm" type="password" value="{{ old('password_confirmation') }}"
                                        class="form-control" name="password_confirmation" required
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
