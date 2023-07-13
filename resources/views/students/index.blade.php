@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                            <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
                            <a href="{{ route('results.exportExcel') }}" class="btn btn-success">Export Excel</a>
                        </div>
                <div class="card">
                
                    <div class="card-header">Add Marks</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="student-select">Select Student</label>
                            <select class="form-control" id="student-select">
                                <option value="">-- Select Student --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subject-select">Select Subject</label>
                            <select class="form-control" id="subject-select">
                                <option value="">-- Select Subject --</option>
                                <option value="Maths">Maths</option>
                                <option value="Science">Science</option>
                                <option value="English">English</option>
                                <option value="Computer">Computer</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="marks-input">Enter Marks</label>
                            <input type="number" class="form-control" id="marks-input">
                        </div>

                        <button type="button" class="btn btn-primary" id="save-marks-btn">Save Marks</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">Student List</div>

                    <div class="card-body">
                        

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Results</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr id="student-row-{{ $student->id }}">
                                        <td>{{ $student->name }}</td>
                                        
                                        <td>
                                            @if ($student->results)

                                            @foreach ($student->results as $result)
                                                <ul>
                                                    @foreach ($result->toArray() as $subject => $marks)
                                                        @if (!in_array($subject, ['id', 'student_id', 'created_at', 'updated_at']))
                                                            <li>
                                                                {{ $subject }} : {{ $marks }}
                                                            </li>   
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endforeach

                                            @else
                                                No results available
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-sm btn-primary">Edit Student</a>
                                            <form action="{{ route('students.destroy', $student->id) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                                            </form>
                                            @if ($student->trashed())
                                                <form action="{{ route('students.restore', $student->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                                </form>
                                                <form action="{{ route('students.forceDelete', $student->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to permanently delete this student?')">Permanently Delete</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('results.pdf', $student->id) }}" target="_blank"
                                                class="btn btn-sm btn-info">View PDF</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function() {
         

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Set the CSRF token value in the request headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $('#save-marks-btn').click(function() {
        var studentId = $('#student-select').val();
        var subject = $('#subject-select').val();
        var marks = $('#marks-input').val();

        if (studentId && subject && marks) {
            $.ajax({
                url: '/results/save-marks',
                method: 'POST',
                data: {
                    student_id: studentId,
                    subject: subject,
                    marks: marks
                },
                success: function(response) {
                    alert('Marks saved successfully!');
                    $('#marks-input').val('');

                    // Update the results for the selected student
                    var studentRow = $('#student-row-' + studentId);
                    var resultsCell = studentRow.find('td:eq(1)');

                    if (response.results && response.results.length > 0) {
                        var resultsHtml = '';
                        response.results.forEach(function(result) {
                            
                            for (var key in result) {
                                if (result.hasOwnProperty(key) && !['id', 'student_id', 'created_at', 'updated_at'].includes(key)) {
                                    resultsHtml += '<li>';
                                    resultsHtml += key + ': ' + result[key];
                                    resultsHtml += '</li>';
                                }
                            }
                            resultsHtml = resultsHtml.slice(0, -2); // Remove the trailing comma and space
                            
                        });

                        resultsCell.html('<ul>' + resultsHtml + '</ul>');
                    } else {
                        resultsCell.html('No results available');
                    } 
                },
                error: function(xhr, status, error) {
                    alert('Error occurred while saving marks.');
                }
            });
        } else {
            alert('Please select student, subject, and enter marks.');
        }
    });
});

    </script>
@endsection
