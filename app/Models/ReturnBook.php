<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_id',
        'return_date',
        'fine'
    ];

        public function loan() {
        return $this->belongsTo(Loan::class);
    }
}
