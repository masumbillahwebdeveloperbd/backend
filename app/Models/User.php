<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use App\Models\Topic;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function ownsTopic(Topic $topic){
        return $this->id===$topic->user->id;
    }
    public function ownsPost(Post $post){
        return $this->id===$post->user->id;
    }
    public function hasLikedPost(Post $post){
        return $post->likes()->where('user_id',$this->id)->count() === 1;
    }

       public function getJWTIdentifier()
    {
        return $this->getKey();
    }
     public function getJWTCustomClaims()
    {
        return [];
    }
}
