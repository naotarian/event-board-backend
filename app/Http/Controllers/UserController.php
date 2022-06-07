<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function user_info(Request $request) {
        $contents = [];
        $contents['user_info'] = User::with('events')->where('name', $request['userName'])->get();
        $res = ['code' => '200', 'contents' => $contents];
        return response()->json($res);
    }
}
