@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">New Matterial</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.matterial.show') }}">Matterials</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.matterial.store') }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select class="form-control" name="subject_id" id="subject">
                                        <option>Select Subjects </option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                        id="name" aria-describedby="name">
                                </div>
                                <div class="form-group">
                                    <label for="details">details</label>
                                    <input type="text" name="details" value="{{ old('details') }}" class="form-control"
                                        id="details" aria-describedby="details">
                                </div>
                                <div class="form-group">
                                    <label for="src">SRC</label>
                                    <input type="text" name="src" value="{{ old('src') }}" class="form-control"
                                        id="details" aria-describedby="src">
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
