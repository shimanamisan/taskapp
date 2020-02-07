<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'title'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
