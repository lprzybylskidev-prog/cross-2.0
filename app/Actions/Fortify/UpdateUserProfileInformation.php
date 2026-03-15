<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Cross\Application\Auth\Data\ProfileInformationData;
use Cross\Application\Auth\UpdateUserProfileInformation as UpdateUserProfileInformationUseCase;
use Cross\Domain\Users\ValueObjects\UserEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function __construct(
        private readonly UpdateUserProfileInformationUseCase $updateUserProfileInformation,
    ) {}

    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        $this->updateUserProfileInformation->handle(
            $user->getKey(),
            new ProfileInformationData(name: $input['name'], email: new UserEmail($input['email'])),
        );
    }
}
