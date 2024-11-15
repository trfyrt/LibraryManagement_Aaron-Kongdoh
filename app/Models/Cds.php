<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cds extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'genre',
        'stock',
        'is_approved'
];

}
