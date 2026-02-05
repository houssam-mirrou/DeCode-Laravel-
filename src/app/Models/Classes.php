<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'name',
        'school_year',
    ];

    public function teachers()
    {
        return $this->belongsToMany(User::class,'teachers_in_classes','class_id','teacher_id');
    }

    public function students()
    {
        return $this->hasMany(User::class,'class_id');
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class,'class_id');
    }
}
