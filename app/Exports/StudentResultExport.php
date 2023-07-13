<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Result;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class StudentResultExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        //$results = Result::with('student')->get();
        $results = Result::with(['student' => function ($query) {
            $query->whereNull('deleted_at');
        }])
        ->get();
        $data = [];

        foreach ($results as $result) {
            $rowData = [
                'ID' => $result->student->id,
                'Name' => $result->student->name,
                'Maths' => $result->Maths,
                'Science' => $result->Science,
                'English' => $result->English,
                'Computer' => $result->Computer,
            ];

            $data[] = $rowData;
        }

        return collect($data);
    }
    public function headings(): array
    {
        return ["ID", "Name", "Maths", "Science", "English", "Computer"];
    }

 
}
