<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Question extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','body','question_tag','user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function questionVotes(){
        return $this->belongsTo(QuestionVote::class);
    }
    public function answer(){
        return $this->hasMany(Answer::class);
    }
    public function questionView(){
        return $this->hasMany(QuestionView::class);
    }
}
