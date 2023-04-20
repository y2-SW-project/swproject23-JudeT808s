<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role');
    }
    protected static function boot()
    {
        parent::boot();

        // Register an event listener for the User model's created event
        static::created(function ($user) {
            // Retrieve the default role
            $defaultRole = Role::where('name', 'user')->first();



            $user->roles()->attach($defaultRole->id);
        });
    }

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
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorzed');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized');
    }
    public function check($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                false;
        }
        return $this->hasRole($roles) ||
            false;
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
}
