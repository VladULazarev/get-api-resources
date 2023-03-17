<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $response = Http::post('https://api-laravel.getyoursite.info/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation
        ]);

        # If 'The email has already been taken'
        if ( $response->json() === null ) {

            return to_route('api-message')
            ->with([
                'message' => "Ваш 'Email' уже занят!",
                'link'    => '/register',
                'button-text' => 'Back to Register'
            ]);
        }

        # Just in case...
        if ( $response->json()['statusCode'] == '422' ) {
            return to_route('api-message')
            ->with([
                'message' => $response->json()['message'],
                'link'    => '/register',
                'button-text' => 'Back to Register'
            ]);
        }

        $response->json();

        # Put 'TOKEN' in session
        session()->put('TOKEN', $response['data']['token'] );
        session()->put('user', $response['data']['user']['name'] );

        return redirect(RouteServiceProvider::HOME);
    }
}
