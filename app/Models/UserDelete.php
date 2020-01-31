<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 追加している

class UserDelete extends Model
{
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
}
