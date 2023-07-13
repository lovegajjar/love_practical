<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentResultExport;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;

 
class ResultController extends Controller
{
    public function create()
    {
        $students = Student::pluck('name', 'id');
        return view('results.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'Maths' => 'required|integer',
            'Science' => 'required|integer',
            'English' => 'required|integer',
            'Computer' => 'required|integer',
        ]);

        Result::create($request->all());

        return redirect()->route('students.index')->with('success', 'Result created successfully.');
    }
    // public function generatePDF($studentId)
    // {
    //     $student = Student::findOrFail($studentId);
    //     $results = $student->results;

    //     $pdf = PDF::loadView('results.result_pdf', compact('student', 'results'));

    //     return $pdf->stream('result.pdf');
    // }
    public function exportExcel()
    {
 
        return Excel::download(new StudentResultExport, 'student_results.xlsx');
    }
    public function show(Student $student)
    {
        $results = $student->results;
 
        return view('results.show', compact('student', 'results'));
    }
   
    public function saveMarks(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required',
            'marks' => 'required|numeric'
        ]);

        $result = Result::where('student_id', $request->student_id)->first();
        if (!$result) {
            $result = new Result();
            $result->student_id = $request->student_id;
        }

        $result->setAttribute($request->subject, $request->marks);
        $result->save();

        // Retrieve the updated results for the student
        $updatedResults = Result::where('student_id', $request->student_id)->get();

        return response()->json([
            'success' => true,
            'results' => $updatedResults
        ]);
    }
    public function generatePdf(Student $student)
    {
        $results = $student->results;

        $html = view('results.pdf', compact('student', 'results'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();

        return Response::make($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="result.pdf"'
        ]);
    }

}
