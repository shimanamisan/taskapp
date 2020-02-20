<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'card_id',
        'status'

    ];

    public function cards()
    {
        return $this->belongsTo('App\Card');
    }

}
