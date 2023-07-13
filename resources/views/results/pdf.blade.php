<!DOCTYPE html>
<html>
<head>
    <title>Student Result</title>
    <style>
         
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Student Result</h1>
    <h2>{{ $student->name }}</h2>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMarks = 0;
            @endphp

            @foreach ($results as $result)
                @foreach ($result->toArray() as $subject => $marks)
                    @if (!in_array($subject, ['id', 'student_id', 'created_at', 'updated_at']))
                        <tr>
                            <td>{{ $subject }}</td>
                            <td>{{ $marks }}</td>
                        </tr>
                        @php
                            $totalMarks += $marks;
                        @endphp
                    @endif
                @endforeach
            @endforeach

            <tr class="total">
                <td>Total</td>
                <td>{{ $totalMarks }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
