<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'type',
        'is_approved'
];

}
