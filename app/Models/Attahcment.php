<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attahcment extends Model
{
    use HasFactory;

    protected $table = 'attachment';
    public $incrementing = true;
    protected $fillable = [
        'name',
        'url',
        'size',
        'mime',
        'attachable_id',
        'attachable_type',
    ];

    public function attachable()
    {
        return $this->morphTo(__FUNCTION__, 'attachable_type', 'attachable_id');
    }
}
