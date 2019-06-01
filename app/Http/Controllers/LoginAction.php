<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Http\JsonResponse;

class LoginAction extends Controller
{
    /**
     * シングルアクションコントローラです。 /api/auth に POST されると、これが実行されます
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $idTokenString = $request->input('idToken');

        $firebase = app('firebase');
        logger(print_r($idTokenString,true));
        try {
            $verifiedIdToken = $firebase->getAuth()->verifyIdToken($idTokenString);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'error!!',
                'message' => $e->getMessage()
            ]);
        }

        $uid = $verifiedIdToken->getClaim('sub');
        $firebase_user = $firebase->getAuth()->getUser($uid);
        return response()->json([
            'uid' => $uid,
            'name' => $firebase_user->displayName,
        ]);
    }
}
