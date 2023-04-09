<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ExamController extends Controller
{
    public function loadExamDashboard($id)
    {
        $qnaExam = Exam::where('enterance_id',$id)->with('getQnaExam')->get();
        $atmpt = Exam::where('attempt',$id)->with('getQnaExam')->get();

        if (count($qnaExam) > 0 && count($atmpt) < 2) 
        {
            $attemptCount = ExamAttempt::where(['exam_id'=>$qnaExam[0]['id'], 'user_id'=>auth()->user()->id])->count();
            if ($attemptCount >= $qnaExam[0]['attempt']) {
                return view('student.exam-dashboard',['success'=>false,'msg'=>/*'Your exam attemption has been completed',*/'Siz İmtahanı Tamamladınız!','exam'=>$qnaExam]);
            }
            else if ($qnaExam[0]['date'] == date('Y-m-d')) {
                if(count($qnaExam[0]['getQnaExam']) > 0) 
                {
                    $qna = QnaExam::where('exam_id',$qnaExam[0]['id'])->with('question','answers')->inRandomOrder()->get();
                    return view('student.exam-dashboard',['success'=>true,'exam'=>$qnaExam,'qna'=>$qna]);
                }else{
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam is not available for now!','exam'=>$qnaExam]);
                }
            }
            else if($qnaExam[0]['date'] > date('Y-m-d')){
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam will be start on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
            else{
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam has been expired on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
        }else{
            return view('404');
        }
    }

    public function examSubmit(Request $request)
    {
        $attempt_id = ExamAttempt::insertGetId([
          'exam_id'=>$request->exam_id,
          'user_id'=> Auth::user()->id
        ]);
        $token = Str::random(40);
        $qcount = count($request->q);
        if ($qcount > 0) {

            for($i = 0; $i < $qcount; $i++){
              if(!empty($request->input('ans_'.($i+1))))
              {
                 ExamAnswer::insert([
                   'attempt_id' => $attempt_id,
                   'question_id' => $request->q[$i],
                   'answer_id' => request()->input('ans_'.($i+1))
                 ]);

                 // $exam = Exam::find($request->exam_id);
                 // $exam->enterance_id = $token;
                 // $exam->save(); 
              }
          }
        }

        return view('thank-you');
    }

    public function resultDashboard()
    {
        $attempts = ExamAttempt::where('user_id',Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();
        return view('student.results',compact('attempts'));
    }

    public function reviewQna(Request $request)
    {
        try{
            $attemptData = ExamAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();
            return response()->json(['success'=>true,'msg'=>'Q&A Data','data'=>$attemptData]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
}
