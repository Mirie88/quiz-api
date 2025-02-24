<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class responses extends Model
{
    /** @use HasFactory<\Database\Factories\ResponsesFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'question_id', 
        'selected_answer',
        'is_correct',
         ];

         public function user()
         {
             return $this->belongsTo(User::class);
         }
         public function question()
         {
             return $this->belongsTo(Question::class);
         }
}
