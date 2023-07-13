<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use PDF;



class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('results')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function forceDelete($id)
    {
        Student::withTrashed()->where('id', $id)->forceDelete();

        return redirect()->route('students.index')->with('success', 'Student permanently deleted successfully.');
    }

    public function restore($id)
    {
        Student::withTrashed()->where('id', $id)->restore();

        return redirect()->route('students.index')->with('success', 'Student restored successfully.');
    }
    public function getStudentResultList()
    {
        $students = Student::with('results')->get();

        return response()->json($students);
    }
    public function generateResultPDF($id)
    {
        $student = Student::findOrFail($id);

        $pdf = PDF::loadView('students.result_pdf', compact('student'));

        return $pdf->stream('result.pdf');
    }

}
