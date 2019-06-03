<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class DebugTest extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // http://localhost:8000/api/debug

        // ログファイルに書きだす
        // ヘルパー関数 logger(), info()
        //  JSON 文字列に内部で見やすく整形してくれる。なので、何も考えずに引数に渡してよい。
        $message = ['a' => 1, 'b' => 2, 'c' => 3];
        $message2 = [1,2,3];
        logger($message);
        logger($message2);
        info($message);

        // Logファサード
        // ヘルパー関数と Log ファサードのやってることはまったく同じ
        // Logファサードはファイルの先頭で use Log; しないといけない(ヘルパーの方が便利)
        Log::debug($message);
        Log::debug($message2);
        Log::info($message);
        Log::debug('デバッグメッセージ');
        Log::info('デバッグメッセージ');
    }
}
