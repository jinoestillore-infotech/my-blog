<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SecurityController extends Controller
{
    private const QUESTIONS = [
        'What was the name of your first pet?',
        'In what city were you born?',
        'What was your childhood nickname?',
        'What was the name of your elementary school?',
        'What is the maiden name of your mother?',
        'What was your first car make and model?'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Render security settings page.
     */
    public function index()
    {
        return view('settings.security', [
            'user' => Auth::user(),
            'questions' => self::QUESTIONS,
        ]);
    }

    /**
     * Render the dedicated Password Change view.
     */
    public function showPasswordForm()
    {
        return view('settings.password');
    }

    /**
     * Render the dedicated Security Question setup view.
     */
    public function showQuestionForm()
    {
        $user = Auth::user();
        $questions = self::QUESTIONS;
        return view('settings.question', compact('user', 'questions'));
    }
    
    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $user = Auth::user();

        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' =>
                    'New password must be different from your current password.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        Auth::logoutOtherDevices($request->new_password);

        $request->session()->regenerate();

        return redirect()->route('settings')->with('success', 'Your password has been changed successfully!');
    }

    /**
     * Update recovery question.
     */
    public function updateQuestion(Request $request)
    {
        $request->validate([
            'security_question' => [
                'required',
                Rule::in(self::QUESTIONS),
            ],
            'security_answer' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'password_verification' => [
                'required',
                'current_password',
            ],
        ]);

        $normalizedAnswer = preg_replace(
            '/\s+/',
            ' ',
            strtolower(trim($request->security_answer))
        );

        $request->user()->update([
            'security_question' => $request->security_question,
            'security_answer' => Hash::make($normalizedAnswer),
        ]);

        return redirect()->route('settings')->with('success', 'Your account recovery question has been configured!');
    }
}