<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'comment',
        'review',
        'level',
    ];

    public function student()
    {
        return $this->belongsTo(User::class,'student_id');

    }
    public function competence_grades()
    {
        return $this->belongsToMany(Competence::class, 'evaluation_competences', 'evaluation_id', 'competence_id')
                    ->withPivot('level');
    }

}
