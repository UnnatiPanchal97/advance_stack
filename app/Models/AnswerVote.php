<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AnswerVote extends Model
{
    use HasFactory;
    protected $fillable = ['vote_type'];    
    // protected $with = [''];
    public function replyvote($answerid)
    {
        return $this->where('answer_id','=',$answerid)->where('user_id','=',auth()->id())->get();
    }
}
