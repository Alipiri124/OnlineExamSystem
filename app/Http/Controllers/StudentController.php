<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // public function paidExamDashboard()
    // {
    //     $exams = Exam::where('plan',1)->with('subjects')->orderBy('date','DESC')->get();
    //     return view('student.paid-exams',['exams'=>$exams]);
    // }
}
