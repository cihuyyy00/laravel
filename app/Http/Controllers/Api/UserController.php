<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Nette\Schema\Message;

class UserController extends Controller
{
    public function index() {
        $user = User::all();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Data diambil',
            'data'      => $user
        ]);

        return UserResource::collection($user);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'User tidak ditemukan'
            ]);
        }

        $user->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => 'User berhasil dihapus'
        ]);
    }
}
