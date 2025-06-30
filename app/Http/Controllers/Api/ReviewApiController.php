<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Review;
use Illuminate\Support\Facades\Auth;

class ReviewApiController extends Controller
{
    public function userReviews()
    {
        $user = Auth::user();

        $reviews = Review::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar review user',
            'data' => $reviews,
        ]);
    }
        public function update(Request $request, $id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Review berhasil diperbarui', 'data' => $review]);
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $review->delete();

        return response()->json(['message' => 'Review berhasil dihapus']);
    }
    public function store(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'rating' => 'required|numeric|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $review = Review::create([
        'user_id' => Auth::id(),
        'book_id' => $request->book_id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return response()->json([
        'message' => 'Review berhasil ditambahkan',
        'data' => $review,
    ], 201);
}


}
// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\Review;
// use Illuminate\Support\Facades\Auth;

// class ReviewApiController extends Controller
// {
//     public function userReviews()
//     {
//         $userId = Auth::id();
//         $reviews = Review::with('book')->where('user_id', $userId)->latest()->get();
//         return response()->json($reviews);
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'book_id' => 'required|exists:books,id',
//             'rating' => 'required|numeric|min:1|max:5',
//             'comment' => 'nullable|string',
//         ]);

//         $review = Review::create([
//             'user_id' => Auth::id(),
//             'book_id' => $request->book_id,
//             'rating' => $request->rating,
//             'comment' => $request->comment,
//         ]);

//         return response()->json(['message' => 'Review berhasil ditambahkan', 'data' => $review]);
//     }

//     public function update(Request $request, $id)
//     {
//         $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

//         $request->validate([
//             'rating' => 'required|numeric|min:1|max:5',
//             'comment' => 'nullable|string',
//         ]);

//         $review->update([
//             'rating' => $request->rating,
//             'comment' => $request->comment,
//         ]);

//         return response()->json(['message' => 'Review berhasil diperbarui', 'data' => $review]);
//     }

//     public function destroy($id)
//     {
//         $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
//         $review->delete();

//         return response()->json(['message' => 'Review berhasil dihapus']);
//     }
// }


