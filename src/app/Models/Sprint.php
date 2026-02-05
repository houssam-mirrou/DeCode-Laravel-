<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'class_id'];

    // Relationship to the Class
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Relationship to Briefs
    public function briefs()
    {
        return $this->hasMany(Brief::class, 'sprint_id');
    }
}
