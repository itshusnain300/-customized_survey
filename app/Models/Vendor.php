<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
    ];

    // Accessor for formatted created_at
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Accessor for formatted updated_at
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class, 'vendor_id', 'id');
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function vendorSubmissions()
    {
        return $this->hasMany(VendorSubmittion::class);
    }

    public function hasSubmission($userId, $vendorId)
    {
        return $this->vendorSubmissions()->where('user_id', $userId)->where('vendor_id', $vendorId)->exists();
    }

    public function customerVendors()
    {
        return $this
            ->where('type', 'customer_specific')
            ->latest()
            ->get();
    }

    public function userVendors()
    {
        return $this
            ->whereIn('type', ['basic_set', 'advanced_set'])
            ->latest()
            ->get();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
