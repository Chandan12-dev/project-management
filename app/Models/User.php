<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'fathername',
        'address',
        'whatsapp',
        'pan_number',
        'cv',
        'current_salary',
        'phone',
        'adhar_number',
        'total_experience',
        'job_profile',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];


    public function assignByProject(){
        return $this->hasMany(Project::class,'assign_by');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_users');
    }

    public function attachments()
    {
        return $this->morphMany(Attahcment::class, 'attachable');
    }

    public function workreports()
    {
        return $this->hasMany(workreport::class, 'user_id');
    }
}
