<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    Use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function book() {
        return $this->hasMany(Book::class);
    }
}
