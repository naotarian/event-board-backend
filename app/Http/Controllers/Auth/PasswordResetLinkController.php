<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $request['email'] = openssl_encrypt($request['email'], $aes_type, $aes_key);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        if ($request->wantsJson()) {
            return $status == Password::RESET_LINK_SENT
                ? response()->json(['status' => __($status)])
                : throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
