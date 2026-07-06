<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'mobile_number', 'password', 'roles', 'latitude', 'longitude', 'current_location', 'vehicles', 'selected_vehicle_id', 'profile_photo', 'drivers_license_photo', 'is_online'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return in_array('admin', $this->roles ?? []);
    }

    /**
     * Check if the user is a manager.
     */
    public function isManager(): bool
    {
        return in_array('manager', $this->roles ?? []);
    }

    /**
     * Check if the user has administrative/management panel access.
     */
    public function hasAdminAccess(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

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
            'roles' => 'array',
            'is_online' => 'boolean',
        ];
    }

    public function vehicles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function selectedVehicle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'selected_vehicle_id');
    }
}

