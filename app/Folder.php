<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'title',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function cards()
    {
        return $this->hasMany('App\Card');
    }

}
