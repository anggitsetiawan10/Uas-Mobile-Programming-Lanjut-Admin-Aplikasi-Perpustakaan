<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'status'
    ];

   public function user() {
    return $this->belongsTo(User::class);
}

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function return() {
        return $this->hasOne(ReturnBook::class); 
    }


}
