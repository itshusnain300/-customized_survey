<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'active',
        'company',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function submittedVendors()
    {
        return $this->hasMany(VendorSubmittion::class);
    }

    public function hasSubmission($userId)
    {
        return VendorSubmittion::where('user_id', $userId)->exists();
    }

    public function userCompany(): HasOne
    {
        return $this->hasOne(UserCompany::class);
    }

    public function teamUser($user)
    {
        return User::where('company', $user->company)
            ->where('id', '!=', $user->id)
            ->first();
    }

    public function customerPackage(): HasOne
    {
        return $this->hasOne(CustomerPackage::class, 'customer_id');
    }
    
}
