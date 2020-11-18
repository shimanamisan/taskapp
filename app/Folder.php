<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ["title", "user_id", "priority"];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function cards()
    {
        return $this->hasMany("App\Card");
    }
}
