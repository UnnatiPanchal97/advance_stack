<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
class QuestionVote extends Model
{
    use HasFactory;
   protected $fillable = [ 'vote','question_id', 'user_id' ];
    public function questions()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
}
