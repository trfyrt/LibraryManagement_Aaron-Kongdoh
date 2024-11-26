<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fyps extends Model
{
    protected $fillable = [
        'title',
        'author',
        'supervisor',
        'year',
        'is_approved'
];
}
