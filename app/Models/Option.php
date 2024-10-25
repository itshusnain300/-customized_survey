<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'title',
        'weight',
    ];

    public function question()
    {
        return $this->hasOne(Option::class);
    }
}
