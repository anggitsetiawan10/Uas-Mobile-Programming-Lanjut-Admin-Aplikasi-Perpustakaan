<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'category_id',
        'cover_image',
        'description'
    ];

    // ✅ Agar field ini ditampilkan otomatis di JSON
    protected $appends = ['cover_image_url'];

    /**
     * Relasi dengan kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi dengan peminjaman
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Relasi dengan review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ✅ Accessor: Mendapatkan full URL dari cover image
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-cover.jpg'); // fallback jika tidak ada gambar
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class Book extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'title',
//         'author',
//         'publisher',
//         'year',
//         'stock',
//         'category_id',
//         'cover_image',
//         'description'
//     ];

//     public function loans() {
//         return $this->hasMany(Loan::class);
//     }

//     public function reviews() {
//         return $this->hasMany(Review::class);
//     }
    
//     public function category(){
//         return $this->belongsTo(Category::class);
//     }
    
// }
// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class Book extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $fillable = [
//         'title',
//         'author',
//         'publisher',
//         'year',
//         'stock',
//         'category_id',
//         'cover_image',
//         'description'
//     ];

//     public function loans() {
//         return $this->hasMany(Loan::class);
//     }

//     public function reviews() {
//         return $this->hasMany(Review::class);
//     }
    
//     public function category(){
//         return $this->belongsTo(Category::class);
//     }
// }
