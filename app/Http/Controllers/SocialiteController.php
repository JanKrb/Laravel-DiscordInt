<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function auth(string $provider): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function unauth(string $provider) {
        if ($provider == 'discord') {
            $user = auth()->user();
            $user->discord_id = null;
            $user->save();
        }

        return redirect(route('profile.edit'));
    }

    public function callback(Request $request, string $provider)
    {
        if ($request->filled('error')) {
            return redirect('/');
        }

        $provider_user = Socialite::driver($provider)->user();
        // dd($user);

        if ($provider == 'discord') {
            $user = auth()->user();
            $user->discord_id = $provider_user->id;
            $user->profile_picture = $provider_user->avatar;
            $user->save();
        }

        return redirect(route('profile.edit'));
    }
}
