@extends('admin.layouts.master')
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">Quizzes</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <a class="btn btn-sm btn-info" href="{{ route('admin.quiz.create') }}"> New Quiz</a>
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
                                <th scope="col">Subject</th>
                                <th scope="col">Date</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                                <th scope="col">Total Grade</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizzes as $index => $quiz)
                                <tr>
                                    <th scope="row">{{ ++$index }}</th>
                                    <td>{{ $quiz->course->subject->name }}</td>
                                    <td>{{ $quiz->date }}</td>
                                    <td>{{ $quiz->start_time }}</td>
                                    <td>{{ $quiz->end_time }}</td>
                                    <td>{{ $quiz->total_grade }}</td>
                                    <td> <button disabled style="width: 80px ; font-weight: bold "
                                            class=" text-center text-uppercase btn btn-sm {{ $quiz->status == 'active' ? 'btn-success' : ($quiz->status == 'inactive' ? 'btn-danger' : ($quiz->status == 'expired' ? 'btn-dark' : '')) }}">
                                            {{ $quiz->status }}
                                        </button>
                                    </td>
                                    <td>
                                        <a style=" {{ $quiz->status == 'expired' ? 'pointer-events: none' : '' }}"
                                            href="{{ route('admin.quiz.edit', $quiz->id) }}" class="btn btn-sm btn-info">
                                            edit</a>

                                        <a href="{{ route('admin.quiz.adminDelete', $quiz->id) }}"
                                            class="btn btn-sm btn-danger">
                                            delete</a>

                                        <a href="{{ route('admin.quiz.showSingleQuestion', $quiz->id) }}"
                                            class="btn btn-sm btn-warning">
                                            show
                                        </a>

                                        <a style=" {{ $quiz->status == 'expired' ? 'pointer-events: none' : '' }}"
                                            href="{{ route('admin.quiz.adminAddQuestionToQuiz', $quiz->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Add Question</a>


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
