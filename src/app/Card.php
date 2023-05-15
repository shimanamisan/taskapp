<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ["title", "folder_id", "priority"];

    public function folder()
    {
        return $this->belongsTo("App\Folder");
    }

    public function tasks()
    {
        return $this->hasMany("App\Task");
    }
}
