<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Like extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'likes';
    protected $fillable = [
        'user_id', 'post_id','like'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

}
