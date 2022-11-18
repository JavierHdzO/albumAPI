<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = [
        'name',
        'grade',
        'group',
        'profesor',
        'begin_schedule',
        'end_schedule',
        'album_id'
    ];
    
    public function albums(){
        return $this->belongsTo(Album::class);
    }

    public function photos(){
        return $this->hasMany(Note::class);
    }

    use HasFactory;
}
