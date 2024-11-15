<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newspapers extends Model
{
    protected $fillable = [
        'title',
        'publisher',
        'publish_date',
        'is_available',
        'is_approved'
];

}
