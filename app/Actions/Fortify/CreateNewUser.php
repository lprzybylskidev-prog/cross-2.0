<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Domain\Users\Preferences\UserTheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Permission;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(
                User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                    'preferred_locale' => SystemLocale::default()->value,
                    'preferred_theme' => UserTheme::default()->value,
                ]),
                function (User $user) {
                    Permission::findOrCreate(SystemPermission::DebtorsView->value);
                    Permission::findOrCreate(SystemPermission::PreferencesUpdate->value);
                    $user->givePermissionTo([
                        SystemPermission::DebtorsView->value,
                        SystemPermission::PreferencesUpdate->value,
                    ]);
                    $this->createTeam($user);
                },
            );
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(
            Team::forceCreate([
                'user_id' => $user->id,
                'name' => explode(' ', $user->name, 2)[0] . "'s Team",
                'personal_team' => true,
            ]),
        );
    }
}
