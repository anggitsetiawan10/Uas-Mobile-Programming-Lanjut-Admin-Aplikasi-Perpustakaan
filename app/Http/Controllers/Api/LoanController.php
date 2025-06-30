<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log; // ✅ Tambahkan ini

class LoanController extends Controller
{
    public function index()
{
    $userId = Auth::id();
    $loans = Loan::with('book')->where('user_id', $userId)->latest()->get();
    return response()->json(['data' => $loans]);
}
    public function store(Request $request)
    {
        Log::info('📥 Request Body:', $request->all());
        Log::info('🔐 User ID from Auth::id(): ' . Auth::id());

        if (!Auth::id()) {
            return response()->json(['message' => 'Unauthorized - user not authenticated'], 401);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
        ]);

        $dueDate = Carbon::parse($request->loan_date)->addDays(7);

        $loan = Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'due_date' => $dueDate,
            'status' => 'dibooking',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil',
            'data' => $loan
        ]);
    }
    public function destroy($id)
{
    $loan = Loan::where('id', $id)
        ->where('user_id', Auth::id()) // pastikan hanya user yang punya pinjaman yang bisa hapus
        ->first();

    if (!$loan) {
        return response()->json(['message' => 'Peminjaman tidak ditemukan.'], 404);
    }

    if ($loan->status !== 'dibooking') {
        return response()->json(['message' => 'Hanya peminjaman dengan status "dibooking" yang bisa dihapus.'], 403);
    }

    $loan->delete(); // soft delete
    return response()->json(['message' => 'Peminjaman berhasil dibatalkan.']);
}

}
