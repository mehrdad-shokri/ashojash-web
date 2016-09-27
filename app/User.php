<?php

namespace App;

use App\Http\Controllers\FollowableTrait;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, FollowableTrait, EntrustUserTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'name', 'email', 'password', 'email_token', 'phone', 'bio', 'score'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function reviews()
    {
        return $this->hasMany('App\Review');
    }


    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function photo()
    {
        return $this->morphMany('App\Photo', 'imageable');
    }

    public function hasProfileImg()
    {
        return Photo::where('imageable_type', $this->getMorphClass())->where('imageable_id', $this->getKey())->first() != null ? true : false;
    }

    public function googleOauth()
    {
        return $this->hasOne("App\GoogleOauth");
    }

    public function venuesOwned()
    {
        return $this->hasMany('App\Venue', 'owner_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
