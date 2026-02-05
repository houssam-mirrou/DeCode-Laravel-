<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'class_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function classes()
    {
        return $this->belongsToMany(Classes::class);
    }

    public function is_teacher()
    {
        return $this->role === 'teacher';
    }

    public function is_admin()
    {
        return $this->role === 'admin';
    }

    public function teaching_classes()
    {
        return $this->belongsToMany(Classes::class,'teachers_in_classes','teacher_id','class_id');
    }

    public function student_class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function briefs_managed()
    {
        return $this->hasMany(Brief::class,'brief_teachers','teacher_id','brief_id');
    }

    public function is_student()
    {
        return $this->role === 'student';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
