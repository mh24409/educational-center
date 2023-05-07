@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Update Subject Info.</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>

                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.subject.show') }}"> SUBJECTS</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.subject.update', $subject->id) }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="name">name</label>
                                    <input type="text" name="name" value="{{ $subject->name }}" class="form-control"
                                        id="name" aria-describedby="name">
                                </div>
                                <div class="form-group">
                                    <label for="level">level</label>
                                    <select class="form-control" name="level_id" id="">
                                        <option>Select Level </option>
                                        @foreach ($levels as $level)
                                            <option {{ $subject->level_id = $level->id ? 'selected' : '' }}
                                                value="{{ $level->id }}">{{ $level->level_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">teacher</label>
                                    <select class="form-control" name="teacher_id" id="">
                                        <option>Select Teacher </option>
                                        @foreach ($teachers as $teacher)
                                            <option {{ $subject->teacher = $teacher->id ? 'selected' : '' }}
                                                value="{{ $teacher->id }}">{{ $teacher->username }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="details">details</label>
                                    <input type="text" name="details" value="{{ $subject->details }}"
                                        class="form-control" id="details" aria-describedby="details">
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
