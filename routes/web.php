<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/home', function () {
    return redirect()->route('login');
});
Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [App\Http\Controllers\StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [App\Http\Controllers\StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [App\Http\Controllers\StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [App\Http\Controllers\StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('students.destroy');
    Route::delete('/students/{id}/force-delete', [App\Http\Controllers\StudentController::class, 'forceDelete'])->name('students.forceDelete');
    Route::post('/students/{id}/restore', [App\Http\Controllers\StudentController::class, 'restore'])->name('students.restore');
 



    Route::get('/results/create', [App\Http\Controllers\ResultController::class, 'create'])->name('results.create');
    Route::post('/results', [App\Http\Controllers\ResultController::class, 'store'])->name('results.store');
    Route::get('/results/pdf/{studentId}', [App\Http\Controllers\ResultController::class, 'generatePDF'])->name('results.generatePDF');
    Route::get('/results/export-excel', [App\Http\Controllers\ResultController::class, 'exportExcel'])->name('results.exportExcel');
    
    Route::post('/results/save-marks', [App\Http\Controllers\ResultController::class, 'saveMarks'])->name('save.marks');

    Route::get('/results/{student}/pdf', 'App\Http\Controllers\ResultController@generatePdf')->name('results.pdf');




   


});

