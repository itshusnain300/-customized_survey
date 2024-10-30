<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'basic_set',
        'advanced_set',
        'customer_specific',
    ];

    public function basicSet(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'basic_set', 'id');
    }
    public function advancedSet(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'advanced_set', 'id');
    }
    public function customerSpecific(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'customer_specific', 'id');
    }

    public function vendorSubmissions()
    {
        return $this->hasMany(VendorSubmittion::class);
    }

    public function hasSubmission($userId, $companyId)
    {
        return $this->vendorSubmissions()->where('user_id', $userId)->where('company_id', $companyId)->exists();
    }

    public function companySets(): HasMany
    {
        return $this->hasMany(CompanySets::class);
    }
}
