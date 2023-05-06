<?php

namespace App\Actions\FilamentCompanies;

use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;
use Wallo\FilamentCompanies\Contracts\ResolvesSocialiteUsers;
use Wallo\FilamentCompanies\Features;

class ResolveSocialiteUser implements ResolvesSocialiteUsers
{
    /**
     * Resolve the user for a given provider.
     */
    public function resolve(string $provider): User
    {
        $user = Socialite::driver($provider)->user();

        if (Features::generatesMissingEmails()) {
            $user->email = $user->getEmail() ?? ("{$user->id}@{$provider}".config('app.domain'));
        }

        return $user;
    }
}
