<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua kategori yang belum dihapus (soft delete)
        $categories = Category::whereNull('deleted_at')->select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
