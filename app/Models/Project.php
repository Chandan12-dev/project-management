<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Project extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'status',
        'duration',
        'start_date',
        'assign_by',
        'cat_id',
        'project_details',
    ];


    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'cat_id','id');
    }

    public function assignBy(){
        return $this->belongsTo(User::class, 'assign_by', 'id');
    }

    public function assignTo()
    {
        return $this->belongsToMany(User::class, 'project_users');
    }

    public function attachments()
    {
        return $this->morphMany(Attahcment::class, 'attachable');
    }

    public function workreports()
    {
        return $this->hasMany(workreport::class, 'project_id');
    }
    
}
