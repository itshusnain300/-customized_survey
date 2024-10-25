<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'title',
        'type',
        'category',
        'description',
        'weight',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function userAnswer($userId)
    {
        return $this->hasOne(Answer::class)->where('user_id', $userId)->first();
    }
    
}
