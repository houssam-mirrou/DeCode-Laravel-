<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livrable extends Model
{
    protected $table = 'livrable';
    protected $fillable = [
        'url',
        'comment',
        'submission_date',
        'student_id',
        'brief_id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function brief()
    {
        return $this->belongsTo(Brief::class, 'brief_id');
    }
}
