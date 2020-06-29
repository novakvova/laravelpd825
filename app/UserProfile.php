<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'image', 'userId'
    ];
    public function User()
    {
        return $this->hasOne(User::class);
    }
}
