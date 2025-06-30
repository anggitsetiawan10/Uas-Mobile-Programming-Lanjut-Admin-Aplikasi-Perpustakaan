<?php
namespace App\Models\Api;

use App\Models\Book as BaseBook;

class Book extends BaseBook
{
    // Tambahkan properti agar field virtual 'cover_image_url' ikut di-serialize
    protected $appends = ['cover_image_url'];

    // Accessor untuk cover_image_url
    public function getCoverImageUrlAttribute()
    {
        return url('storage/' . $this->cover_image);
    }

    // Jika kamu ingin menyembunyikan field asli 'cover_image', bisa tambahkan ini:
    // protected $hidden = ['cover_image'];
}
