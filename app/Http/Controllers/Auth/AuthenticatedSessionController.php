<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $response = Http::post('https://api-laravel.getyoursite.info/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ( $response->json()['statusCode'] == '401' ||
             $response->json()['statusCode'] == '422' )
        {
            return to_route('api-message')
            ->with([
                'message' => $response->json()['message'],
                'link'    => '/login',
                'button-text' => 'Back to Log in'
            ]);
        }

        $response->json();

        # Put 'TOKEN' in session
        session()->put('TOKEN', $response['data']['token'] );
        session()->put('user', $response['data']['user']['name'] );

        return redirect('tasks');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(): RedirectResponse
    {
        Http::acceptJson()
        ->withToken(session('TOKEN'))
        ->post('https://api-laravel.getyoursite.info/api/logout');

        session()->forget('TOKEN');

        return redirect('/');
    }
}
