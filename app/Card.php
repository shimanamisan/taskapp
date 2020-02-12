<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'title',
        'folder_id'
    ];

    public function folders()
    {
        return $this->belongsTo('App\Folder');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}