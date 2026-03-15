<?php

declare(strict_types=1);

namespace Cross\Infrastructure\Auth;

use App\Models\Team;
use App\Models\User;
use Cross\Application\Auth\Contracts\AuthUserGateway;
use Cross\Application\Auth\Data\NewUserData;
use Cross\Application\Auth\Data\ProfileInformationData;
use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Security\Permissions\SystemPermission;
use Cross\Domain\Teams\PersonalTeamName;
use Cross\Domain\Users\Preferences\UserTheme;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

final class EloquentAuthUserGateway implements AuthUserGateway
{
    public function register(NewUserData $data): int
    {
        /** @var User $user */
        $user = DB::transaction(function () use ($data): User {
            $user = User::query()->create([
                'name' => $data->name,
                'email' => $data->email->value,
                'password' => Hash::make($data->password),
                'preferred_locale' => SystemLocale::default()->value,
                'preferred_theme' => UserTheme::default()->value,
            ]);

            Permission::findOrCreate(SystemPermission::DebtorsView->value);
            Permission::findOrCreate(SystemPermission::PreferencesUpdate->value);

            $user->givePermissionTo([
                SystemPermission::DebtorsView->value,
                SystemPermission::PreferencesUpdate->value,
            ]);

            $user->ownedTeams()->save(
                Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => PersonalTeamName::fromOwnerName($user->name)->value,
                    'personal_team' => true,
                ]),
            );

            return $user;
        });

        return $user->getKey();
    }

    public function updateProfileInformation(int $userId, ProfileInformationData $data): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        if ($data->email->value !== $user->email && $user instanceof MustVerifyEmail) {
            $user
                ->forceFill([
                    'name' => $data->name,
                    'email' => $data->email->value,
                    'email_verified_at' => null,
                ])
                ->save();

            $user->sendEmailVerificationNotification();

            return;
        }

        $user
            ->forceFill([
                'name' => $data->name,
                'email' => $data->email->value,
            ])
            ->save();
    }

    public function updatePassword(int $userId, string $password): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        $user
            ->forceFill([
                'password' => Hash::make($password),
            ])
            ->save();
    }
}
