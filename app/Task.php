<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'card_id',

    ];

    public function card()
    {
        return $this->belongsTo('App\Card');
    }

}
