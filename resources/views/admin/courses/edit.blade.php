@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Update Course Info.</h3>
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
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.course.update', $course->id) }}">
                                @csrf
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                                <div class=" text-center">
                                    <img height="100px" width="100px"
                                        src="{{ asset('uploads/images/courses/' . $course->image) }}" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="details">details</label>
                                    <input type="text" name="details" value="{{ $course->details }}" class="form-control"
                                        id="details" aria-describedby="details">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select class="form-control" name="subject_id" id="subject">
                                        <option> Select Subject </option>
                                        @foreach ($subjects as $subject)
                                            <option {{ $course->subject->id == $subject->id ? 'selected' : '' }}
                                                value="{{ $subject->id }}">{{ $subject->name }}</option>
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
                                    <input type="number" name="no_of_students" value="{{ $course->no_of_students }}"
                                        class="form-control" id="no_of_students" aria-describedby="no_of_students">
                                </div>
                                <div class="form-group">
                                    <label for="no_of_avilables">No Of Avilables</label>
                                    <input type="number" name="no_of_avilables" value="{{ $course->no_of_avilables }}"
                                        class="form-control" id="no_of_avilables" aria-describedby="no_of_avilables">
                                </div>

                                <div class="form-group">
                                    <label for="firstday">First Day</label>
                                    <select class="form-control" name="firstday" id="firstday">
                                        <option> Select Day </option>
                                        <option value="sunday"> sunday
                                        </option>
                                        <option value="monday"> monday
                                        </option>
                                        <option value="tuesday">
                                            tuesday
                                        </option>
                                        <option value="wednesday">
                                            wednesday </option>
                                        <option value="thursday">
                                            thursday
                                        </option>
                                        <option value="saturday">
                                            saturday
                                        </option>
                                        <option value="friday"> friday
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="firstdaytime">First Day Time</label>
                                    <select class="form-control" name="firstdaytime" id="firstdaytime">
                                        <option> Select Time </option>
                                        <option value="first">
                                            First
                                        </option>
                                        <option value="second">
                                            Second
                                        </option>
                                        <option value="third">
                                            Third
                                        </option>
                                        <option value="fourth">
                                            Fourth
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="secondday">Second Day</label>
                                    <select class="form-control" name="secondday" id="secondday">
                                        <option> Select Day </option>
                                        <option value="sunday"> sunday
                                        </option>
                                        <option value="monday"> monday
                                        </option>
                                        <option value="tuesday">
                                            tuesday
                                        </option>
                                        <option value="wednesday">
                                            wednesday </option>
                                        <option value="thursday">
                                            thursday
                                        </option>
                                        <option value="saturday">
                                            saturday
                                        </option>
                                        <option value="friday"> friday
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="seconddaytime">Second Day Time</label>
                                    <select class="form-control" name="seconddaytime" id="seconddaytime">
                                        <option> Select Time </option>
                                        <option value="first">
                                            First
                                        </option>
                                        <option value="second">
                                            Second
                                        </option>
                                        <option value="third">
                                            Third
                                        </option>
                                        <option value="fourth">
                                            Fourth
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" value="{{ $course->start_date }}"
                                        class="form-control" id="start_date" aria-describedby="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" value="{{ $course->end_date }}"
                                        class="form-control" id="end_date" aria-describedby="end_date">
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status"
                                        {{ $course->status == 1 ? 'checked' : '' }} name="status">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                </div>
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
