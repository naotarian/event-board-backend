<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return;
        }
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        $decode_user = json_decode($request->user(), true);
        $decode_user['email'] = openssl_decrypt($decode_user['email'], $aes_type, $aes_key);
        $decode_user['name'] = openssl_decrypt($decode_user['name'], $aes_type, $aes_key);
        $request->user()->fill(['email' => $decode_user['email'], 'name' => $decode_user['name']])->sendEmailVerificationNotification();

        return $request->wantsJson() ?
            response()->json(['status' => 'verification-link-sent']) :
            back()->with('status', 'verification-link-sent');
    }
}
