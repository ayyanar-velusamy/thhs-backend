<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ForgotPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function emergency_contacts(): HasMany {
        return $this->hasMany(EmergencyContacts::class);
    }

    public function work_history(): HasMany {
        return $this->hasMany(WorkHistory::class);
    }

    public function user_education(): HasMany {
        return $this->hasMany(UserEducation::class);
    }

    public function professional_references(): HasMany {
        return $this->hasMany(ProfessionalReferences::class);
    }

    public function addresses(): HasMany {
        return $this->hasMany(UserAddresses::class);
    }

    public function phone_numbers(): HasMany {
        return $this->hasMany(UserPhoneNumbers::class);
    }

    public function email_addresses(): HasMany {
        return $this->hasMany(UserEmailAdresses::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'position',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ForgotPasswordNotification($token));
    }
    
}
