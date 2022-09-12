<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id', 'answer', 'user_id', 'count', 'type',
    ];
    public function user()
        {
            return $this->belongsTo(User::class,'user_id','id');
        }  
}
