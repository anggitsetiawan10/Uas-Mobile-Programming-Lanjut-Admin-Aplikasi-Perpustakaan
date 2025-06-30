<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return response()->json([
            'profile' => $profile
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|string|in:Laki-laki,Perempuan,Lainnya',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'phone' => 'required|string',
            'address' => 'required|string',
            'occupation' => 'nullable|string',
            'institution' => 'nullable|string',
        ]);

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            array_merge($data, ['user_id' => $user->id])
        );

        return response()->json([
            'message' => 'Profil berhasil disimpan',
            'profile' => $profile
        ]);
    }
}
