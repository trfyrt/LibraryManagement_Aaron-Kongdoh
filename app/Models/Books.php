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

    public function borrowedBy()
    {
        return $this->belongsToMany(User::class, 'borrow', 'book_id', 'user_id')
                    ->withPivot('days_left', 'created_at', 'updated_at');
    }

}
