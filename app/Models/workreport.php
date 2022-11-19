<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workreport extends Model
{
    use HasFactory;

    protected $table = 'workreports';

    protected $fillable = [
        'project_id',
        'user_id',
        'report_date',
        'start_time',
        'duration',
        'end_time',
        'comment',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
