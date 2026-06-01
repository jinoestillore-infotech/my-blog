<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Display the email request form.
     */
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Verify that the email exists and has a configured security question.
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'No account was found with that email address.'
        ]);

        $user = User::where('email', $request->email)->first();

        // Ensure the user has actually configured a recovery question
        if (empty($user->security_question) || empty($user->security_answer)) {
            return back()->withErrors([
                'email' => 'This account has not configured security recovery details. Please contact administrator support.'
            ])->withInput();
        }

        // Store the verified email temporarily in session to keep the multi-step form secure
        session(['password_reset_email' => $user->email]);

        return redirect()->route('password.reset.form');
    }

    /**
     * Display the security question challenge and password reset form.
     */
    public function showResetForm()
    {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Please verify your email address first.']);
        }

        $user = User::where('email', $email)->firstOrFail();

        return view('auth.reset-password-security', [
            'question' => $user->security_question,
            'email' => $email
        ]);
    }

    /**
     * Process the answer verification and update the password.
     */
    public function resetPassword(Request $request)
    {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Your session has expired. Please verify your email again.']);
        }

        $request->validate([
            'security_answer' => ['required', 'string'],
            'password' => [
                'required', 
                'confirmed', 
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        $user = User::where('email', $email)->firstOrFail();

        // Normalize security answer formatting (lowercase + single spacing) to match our registration setup
        $normalizedAnswerInput = preg_replace('/\s+/', ' ', strtolower(trim($request->security_answer)));

        if (!Hash::check($normalizedAnswerInput, $user->security_answer)) {
            return back()->withErrors([
                'security_answer' => 'The answer you provided is incorrect. Please check your spelling and try again.'
            ]);
        }

        // Update with newly hashed password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Clean up recovery variables from state
        session()->forget('password_reset_email');

        return redirect()->route('login')
            ->with('success', 'Your password has been reset successfully! Please sign in with your new credentials.');
    }
}