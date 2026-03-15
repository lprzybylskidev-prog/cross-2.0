<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Cross\Application\Auth\UpdateUserPassword as UpdateUserPasswordUseCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    public function __construct(private readonly UpdateUserPasswordUseCase $updateUserPassword) {}

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function update(User $user, array $input): void
    {
        Validator::make(
            $input,
            [
                'current_password' => ['required', 'string', 'current_password:web'],
                'password' => $this->passwordRules(),
            ],
            [
                'current_password.current_password' => __(
                    'The provided password does not match your current password.',
                ),
            ],
        )->validateWithBag('updatePassword');

        $this->updateUserPassword->handle($user->getKey(), $input['password']);
    }
}
