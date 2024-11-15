<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publish_date',
        'abstract',
        'is_approved'
];
}
