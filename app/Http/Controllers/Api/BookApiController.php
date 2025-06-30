<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Book; // <--- gunakan model turunan khusus API
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 

class BookApiController extends Controller
{
    public function latest()
    {
        try {
            $books = Book::with('category')
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar buku terbaru',
                'data' => $books,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // app/Http/Controllers/Api/BookController.php


public function getAvailableYears(){
        $years = DB::table('books')
            ->whereNull('deleted_at')
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return response()->json($years);
    }
public function search(Request $request)
{
        $query = Book::query(); 

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                ->orWhere('author', 'like', '%' . $request->q . '%')
                ->orWhere('year', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('genre')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->genre);
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        return response()->json([
            'success' => true,
            'data' => $query->with('category')->get()
        ]);
    }
public function mostBorrowed()
{
    $books = Book::with('category')
                ->withCount('loans')
                ->orderByDesc('loans_count')
                ->take(10)
                ->get();

    return response()->json([
        'success' => true,
        'message' => 'Buku paling banyak dipinjam',
        'data' => $books,
    ]);
}

// public function topRated()
// {
//     $books = Book::with('category')
//                 ->withAvg('reviews', 'rating')
//                 ->orderByDesc('reviews_avg_rating')
//                 ->take(10)
//                 ->get();

//     return response()->json([
//         'success' => true,
//         'message' => 'Buku dengan rating tertinggi',
//         'data' => $books,
//     ]);
// }
public function topRated()
{
    $books = Book::select('books.*')
                ->with('category')
                ->join('reviews', 'books.id', '=', 'reviews.book_id')
                ->selectRaw('AVG(reviews.rating) as avg_rating, COUNT(reviews.id) as review_count, SUM(reviews.rating) as total_rating')
                ->groupBy('books.id')
                ->orderByDesc('avg_rating')
                ->orderByDesc('review_count') // atau total_rating
                ->take(10)
                ->get();

    return response()->json([
        'success' => true,
        'message' => 'Buku dengan rating tertinggi',
        'data' => $books,
    ]);
}


}
