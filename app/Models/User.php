<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'password','birthday', 'email', 'fullname', 'path', 'type','major','description'
    ];

    protected $hidden = [
        'password',
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {

            $minUserId = self::orderBy('id')->pluck('id')->first();

            if ($minUserId) {
                self::where('id', '>', $user->id)->decrement('id');
                DB::statement("ALTER TABLE users AUTO_INCREMENT = $minUserId");
            }
        });
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }
    
    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id'); 
    }
    
    public function permissions()
    {
        return $this->belongsToMany(UserPermission::class, 'user_permissions'); 
    }

}