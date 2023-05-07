@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">New Course</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.course.show') }}">Courses</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.course.store') }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class="form-group">
                                    <label for="details">details</label>
                                    <input type="text" name="details" value="{{ old('details') }}" class="form-control"
                                        id="details" aria-describedby="details">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select class="form-control" name="subject_id" id="subject">
                                        <option> Select Subject </option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" value="{{ old('image') }}" class="form-control"
                                        id="image" aria-describedby="image">
                                </div>
                                <div class="form-group">
                                    <label for="no_of_students">No Of Students</label>
                                    <input type="number" name="no_of_students" value="{{ old('no_of_students') }}"
                                        class="form-control" id="no_of_students" aria-describedby="no_of_students">
                                </div>
                                <div class="form-group">
                                    <label for="firstday">First Day</label>
                                    <select class="form-control" name="firstday" id="firstday">
                                        <option> Select Day </option>
                                        <option {{ old('firstday') == 'sunday' ? 'selected' : '' }} value="sunday"> sunday
                                        </option>
                                        <option {{ old('firstday') == 'monday' ? 'selected' : '' }} value="monday"> monday
                                        </option>
                                        <option {{ old('firstday') == 'tuesday' ? 'selected' : '' }} value="tuesday">
                                            tuesday
                                        </option>
                                        <option {{ old('firstday') == 'wednesday' ? 'selected' : '' }} value="wednesday">
                                            wednesday </option>
                                        <option {{ old('firstday') == 'thursday' ? 'selected' : '' }} value="thursday">
                                            thursday
                                        </option>
                                        <option {{ old('firstday') == 'saturday' ? 'selected' : '' }} value="saturday">
                                            saturday
                                        </option>
                                        <option {{ old('firstday') == 'friday' ? 'selected' : '' }} value="friday"> friday
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="firstdaytime">First Day Time</label>
                                    <select class="form-control" name="firstdaytime" id="firstdaytime">
                                        <option> Select Time </option>
                                        <option {{ old('firstdaytime') == 'first' ? 'selected' : '' }} value="first">
                                            First
                                        </option>
                                        <option {{ old('firstdaytime') == 'second' ? 'selected' : '' }} value="second">
                                            Second
                                        </option>
                                        <option {{ old('firstdaytime') == 'third' ? 'selected' : '' }} value="third">
                                            Third
                                        </option>
                                        <option {{ old('firstdaytime') == 'fourth' ? 'selected' : '' }} value="fourth">
                                            Fourth
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="secondday">Second Day</label>
                                    <select class="form-control" name="secondday" id="secondday">
                                        <option> Select Day </option>
                                        <option {{ old('secondday') == 'sunday' ? 'selected' : '' }} value="sunday"> sunday
                                        </option>
                                        <option {{ old('secondday') == 'monday' ? 'selected' : '' }} value="monday"> monday
                                        </option>
                                        <option {{ old('secondday') == 'tuesday' ? 'selected' : '' }} value="tuesday">
                                            tuesday
                                        </option>
                                        <option {{ old('secondday') == 'wednesday' ? 'selected' : '' }} value="wednesday">
                                            wednesday </option>
                                        <option {{ old('secondday') == 'thursday' ? 'selected' : '' }} value="thursday">
                                            thursday
                                        </option>
                                        <option {{ old('secondday') == 'saturday' ? 'selected' : '' }} value="saturday">
                                            saturday
                                        </option>
                                        <option {{ old('secondday') == 'friday' ? 'selected' : '' }} value="friday"> friday
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="seconddaytime">Second Day Time</label>
                                    <select class="form-control" name="seconddaytime" id="seconddaytime">
                                        <option> Select Time </option>
                                        <option {{ old('seconddaytime') == 'first' ? 'selected' : '' }} value="first">
                                            First
                                        </option>
                                        <option {{ old('seconddaytime') == 'second' ? 'selected' : '' }} value="second">
                                            Second
                                        </option>
                                        <option {{ old('seconddaytime') == 'third' ? 'selected' : '' }} value="third">
                                            Third
                                        </option>
                                        <option {{ old('seconddaytime') == 'fourth' ? 'selected' : '' }} value="fourth">
                                            Fourth
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                                        class="form-control" id="start_date" aria-describedby="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                                        class="form-control" id="end_date" aria-describedby="end_date">
                                </div>
                                <label class="text-danger"> by default course status will be inactive , to active update
                                    this course </label>
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
