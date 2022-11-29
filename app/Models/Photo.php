<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public $fillable = [
        'url',
        'type',
        'status',
        'schedule',
        'subject_id'
    ];

    public function subject(){
        $this->belongsTo(Subject::class);
    }
}
