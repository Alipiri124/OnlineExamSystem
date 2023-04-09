<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExamAttempt;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
     'exam_name',
     'subject_id',
     'date',
     'time',
     'attempt',
     //'plan',
    // 'prices'
    ];
    
    protected $appends = [
     'attempt_counter'
    ];
    public $count = '';

    public function subjects()
    {
       return $this->hasMany(Subject::class,'id','subject_id');
    }

    public function getQnaExam()
    {
       return $this->hasMany(QnaExam::class,'exam_id','id');
    }

    public function getIdAttribute($value)
    {
       $attemptCount = ExamAttempt::where(['exam_id'=>$value, 'user_id'=>auth()->user()->id])->count();
       $this->count = $attemptCount;
       return $value;
    }

    public function getAttemptCounterAttribute()
    {
       return $this->count;
    }
}
