<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Item;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'usertype',
        'username',
        'first_name',
        'last_name',
        'address',
        'phone',
        'email',
        'usertype',
        'password',
    ];

    protected function profile(): Attribute
    {
        return Attribute::make(get: function($value)
        {
           return $value ? '' . $value : 'profiles/fallback-profile.jpg';
        });
    }

    // protected function profile(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value ? '/storage/' . $value : '/fallback-avatar.jpg',
    //     );
    // }


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

    public function items()
    {
        return $this->hasMany(Item::class, 'user_id');
    }

    public function feedPosts()
    {
        return $this->hasManyThrough();
    }
}
