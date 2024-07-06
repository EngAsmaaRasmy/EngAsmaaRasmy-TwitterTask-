<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));
        $this->auth = $factory->createAuth();
    }

    public function verifyIdToken($idToken)
    {
        return $this->auth->verifyIdToken($idToken);
    }
}