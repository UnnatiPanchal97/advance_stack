<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
    use HasFactory;
    protected $fillable=[
        'tag','user_id'
    ];
    public function tagUser(){
        return $this->belongsTo(User::class);
    }
}
