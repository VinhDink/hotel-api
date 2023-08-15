<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('emailVerificationNotice', 'verifyEmail');
    }

    /**
     * Show the email verification notice.
     *
     * @return \Illuminate\View\View
     */
    public function emailVerificationNotice()
    {
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('home')->with('success', 'Email verified successfully!');
    }

    /**
     * Send email to user
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailVerificationNotice(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification email sent!');
    }
}
