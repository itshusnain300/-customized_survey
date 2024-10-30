<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPackage extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'package_id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
