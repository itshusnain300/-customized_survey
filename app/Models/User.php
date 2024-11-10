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
        'company_name',
        'company_id',
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

    // public function userCompany(): HasOne
    // {
    //     return $this->hasOne(UserCompany::class);
    // }

    public function teamUser($user)
    {
        return User::where('users.company_id', $user->company_id)  // Use company_id from users table
            ->where('users.id', '!=', $user->id)                    // Exclude the current user
            ->join('companies', 'companies.id', '=', 'users.company_id')  // Join with companies table on company_id
            ->first();
    }
    
    
    
    

    public function customerPackage(): HasOne
    {
        return $this->hasOne(CustomerPackage::class, 'customer_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    
}
