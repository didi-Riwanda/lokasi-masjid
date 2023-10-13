<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function process(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];
        if ($this->guard()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('admin.home');
        } else {
            throw ValidationException::withMessages([
                'username' => ['Username dan kata sandi salah.'],
            ]);
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->back();
    }

    /**
     *
     * @return Illuminate\Support\Facades\Auth
     */
    protected function guard()
    {
        return Auth::guard();
    }

}
