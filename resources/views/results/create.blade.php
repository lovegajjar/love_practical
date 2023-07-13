@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add Result</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('results.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="student_id">Student</label>
                                <select id="student_id" class="form-control" name="student_id" required>
                                    <option value="">Select Student</option>
                                    @foreach ($students as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>

                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Maths">Maths Marks</label>
                                <input id="Maths" type="number"
                                    class="form-control @error('Maths') is-invalid @enderror"
                                    name="Maths" value="{{ old('Maths') }}" required>

                                @error('Maths')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Science">Science Marks</label>
                                <input id="Science" type="number"
                                    class="form-control @error('Science') is-invalid @enderror"
                                    name="Science" value="{{ old('Science') }}" required>

                                @error('Science')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="English">English Marks</label>
                                <input id="English" type="number"
                                    class="form-control @error('English') is-invalid @enderror"
                                    name="English" value="{{ old('English') }}" required>

                                @error('English')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Computer">Computer Marks</label>
                                <input id="Computer" type="number"
                                    class="form-control @error('Computer') is-invalid @enderror"
                                    name="Computer" value="{{ old('Computer') }}" required>

                                @error('Computer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
