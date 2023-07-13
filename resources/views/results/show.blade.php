@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $student->name }} Results</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                    @foreach ($result->toArray() as $subject => $marks)
                                        @if (!in_array($subject, ['id', 'student_id', 'created_at', 'updated_at']))
                                            <tr>
                                                <td>{{ $subject }}</td>
                                                <td>{{ $marks }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
