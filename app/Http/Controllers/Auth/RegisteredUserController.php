<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, CreateNewUser $createNewUser): RedirectResponse
    {
        $user = $createNewUser->create($request->all());

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
