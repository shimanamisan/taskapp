<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
