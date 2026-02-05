<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = [
        'code',
        'libelle',
        'description',
    ];
    public function briefs()
    {
        return $this->belongsToMany(
            Brief::class,
            'brief_competences',
            'competence_id',
            'brief_id'
        )->withPivot('level');
    }
    public function evaluations()
    {
        return $this->belongsToMany(
            Evaluation::class,
            'evaluation_competences',
            'competence_id',
            'evaluation_id'
        )->withPivot('level');
    }
}
