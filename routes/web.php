<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
//use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',[AuthController::class,'loadRegister']);
Route::post('/register',[AuthController::class,'studentRegister'])->name('studentRegister');

// Route::get('/login', function () {
//     return redirect('/');
// });
Route::get('/',[AuthController::class,'loadLogin'])->name('login');
Route::post('/login',[AuthController::class,'userLogin'])->name('userLogin');

Route::get('/logout',[AuthController::class,'logout']);

Route::get('/forget-password',[AuthController::class,'forgetPasswordLoad']);
Route::post('/forget-password',[AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password',[AuthController::class,'resetPasswordLoad']);
Route::post('/reset-password',[AuthController::class,'resetPassword'])->name('resetPassword');

Route::group(['middleware'=>['web','checkAdmin']],function(){
   Route::get('/admin/dashboard',[AuthController::class,'adminDashboard']);
   //subjects route
   Route::post('/add-subject',[AdminController::class,'addSubject'])->name('addSubject');
   Route::post('/edit-subject',[AdminController::class,'editSubject'])->name('editSubject');
   Route::post('/delete-subject',[AdminController::class,'deleteSubject'])->name('deleteSubject');
   //exam route
   Route::get('/admin/exam',[AdminController::class,'examDashboard']);
   Route::post('/add-exam',[AdminController::class,'addExam'])->name('addExam');
   //exam edit
   Route::get('/get-exam-detail/{id}',[AdminController::class,'getExamDetail'])->name('getExamDetail');
   Route::post('/update-exam',[AdminController::class,'updateExam'])->name('updateExam');
   Route::post('/delete-exam',[AdminController::class,'deleteExam'])->name('deleteExam');
   //Q&A Routes
   Route::get('/admin/qna-ans',[AdminController::class,'qnaDashboard']);
   Route::post('/add-qna-ans',[AdminController::class,'addQna'])->name('addQna');
   Route::get('/get-qna-details',[AdminController::class,'getQnaDetails'])->name('getQnaDetails');
   Route::get('/delete-ans',[AdminController::class,'deleteAns'])->name('deleteAns');
   Route::post('/update-qna-ans',[AdminController::class,'updateQna'])->name('updateQna');
   Route::post('/delete-qna-ans',[AdminController::class,'deleteQna'])->name('deleteQna');
   Route::post('/import-qna-ans',[AdminController::class,'importQna'])->name('importQna');

   //Students routing
   Route::get('/admin/students',[AdminController::class,'studentsDashboard']);
   Route::post('/add-student',[AdminController::class,'addStudent'])->name('addStudent');
   Route::post('/edit-student',[AdminController::class,'editStudent'])->name('editStudent');
   Route::post('/delete-student',[AdminController::class,'deleteStudent'])->name('deleteStudent');
   Route::get('/export-students',[AdminController::class,'exportStudents'])->name('exportStudents');

   //qna exams routing
   Route::get('/get-questions',[AdminController::class,'getQuestions'])->name('getQuestions');
   Route::post('/add-questions',[AdminController::class,'addQuestions'])->name('addQuestions');
   Route::get('/get-exam-questions',[AdminController::class,'getExamQuestions'])->name('getExamQuestions');
   Route::get('/delete-exam-questions',[AdminController::class,'deleteExamQuestions'])->name('deleteExamQuestions');
   //exam marks routes
   Route::get('/admin/marks',[AdminController::class,'loadMarks']);
   Route::post('/admin/marks',[AdminController::class,'updateMarks'])->name('updateMarks');
   //exam rewiew routes
   Route::get('/admin/review-exams',[AdminController::class,'reviewExams'])->name('reviewExams');
   Route::get('/get-reviewed-qna',[AdminController::class,'reviewQna'])->name('reviewQna');

   Route::post('/approved-qna',[AdminController::class,'approvedQna'])->name('approvedQna');
});
Route::group(['middleware'=>['web','checkStudent']],function(){
    Route::get('/dashboard',[AuthController::class,'loadDashboard']);
    Route::get('/exam/{id}',[ExamController::class,'loadExamDashboard']);

    Route::post('/exam-submit',[ExamController::class,'examSubmit'])->name('examSubmit');

    Route::get('/results',[ExamController::class,'resultDashboard'])->name('resultDashboard');
    Route::get('/review-student-qna',[ExamController::class,'reviewQna'])->name('resultStudentQna');
    // Route::get('/paid-exams',[StudentController::class,'paidExamDashboard'])->name('paidExamDashboard');
});




