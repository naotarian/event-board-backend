<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct() {
        $this->aes_key = config('app.aes_key');
        $this->aes_type = config('app.aes_type');
    }
    public function user_info(Request $request) {
        $contents = [];
        $contents['user_info'] = User::with('events')->where('name', openssl_encrypt($request['userName'], $this->aes_type, $this->aes_key))->first();
        $res = ['code' => '200', 'contents' => $contents];
        return response()->json($res);
    }

    public function my_page(Request $request) {
        $user = json_decode($request->user(), true);
        $contents = [];
        $contents['user_info'] = User::with('events')->find($user['id']);
        $res = ['code' => '200', 'contents' => $contents];
        return response()->json($res);
    }
}
