<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function verifyToken(Request $request)
    {
        $idToken = $request->input('idToken');
        $verifiedIdToken = $this->authRepository->verifyToken($idToken);

        if ($verifiedIdToken) {
            $uid = $verifiedIdToken->claims()->get('sub');

            Auth::loginUsingId($uid);

            return response()->json(['status' => 'success', 'message' => 'User authenticated']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid token']);
        }
    }
}
