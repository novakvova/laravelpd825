<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'id',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);//('App\Category', 'foreign_key');
    }
}
