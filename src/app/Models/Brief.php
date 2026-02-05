<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brief extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date_remise',
        'type',
        'sprint_id'
    ];
    public function sprints()
    {
        return $this->belongsTo(Sprint::class,'sprint_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class,'brief_teachers','brief_id','teacher_id');
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class,'brief_competences', 'brief_id', 'competence_id')
                    ->withPivot('level');
    }

    public function livrables()
    {
        return $this->hasMany(Livrable::class,'brief_id');
    }
}
