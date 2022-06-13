<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
        Auth::login($user = User::create([
            'name' => openssl_encrypt($request->name, $aes_type, $aes_key),
            'email' => openssl_encrypt($request->email, $aes_type, $aes_key),
            'password' => Hash::make($request->password),
        ]));
        $docode_user = json_decode($user, true);
        $docode_user['email'] = openssl_decrypt($docode_user['email'], $aes_type, $aes_key);
        $docode_user['name'] = openssl_decrypt($docode_user['name'], $aes_type, $aes_key);
        $docode_user = json_encode($docode_user);
        
        event(new Registered($docode_user));

        return response()->noContent();
    }
}
