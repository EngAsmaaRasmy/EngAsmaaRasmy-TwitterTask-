<?php

namespace App\Repositories;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;

class AuthRepository
{
    protected $auth;

    public function __construct()
    {
        $firebaseCredentialsPath = base_path('storage/' . env('FIREBASE_CREDENTIALS'));

        $this->auth = (new Factory)
           ->withServiceAccount($firebaseCredentialsPath)
            ->createAuth();
    }

    public function verifyToken($idToken)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            return $verifiedIdToken;
        } catch (\Exception $e) {
            return false;
        }
    }
}
