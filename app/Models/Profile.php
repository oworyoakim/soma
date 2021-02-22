<?php

namespace App\Models;

/**
 * Class Profile
 * @package App\Models
 * @property int id
 * @property int user_id
 */
class Profile extends Model
{
    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
