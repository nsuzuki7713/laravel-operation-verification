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
        // firebaseインスタンスを注入
        $firebase = app('firebase');

        $idTokenString = $request->input('idToken');

        try {
            // Tokenの認証
            $verifiedIdToken = $firebase->getAuth()->verifyIdToken($idTokenString);
            // logger(print_r($verifiedIdToken,true));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'error!!',
                'message' => $e->getMessage()
            ]);
        }

        $uid = $verifiedIdToken->getClaim('sub');
        $name = $verifiedIdToken->getClaim('name');

        return response()->json([
            'uid' => $uid,
            'name' => $name
        ]);
    }
}
