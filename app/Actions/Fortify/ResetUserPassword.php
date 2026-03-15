<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Cross\Application\Auth\ResetUserPassword as ResetUserPasswordUseCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    public function __construct(private readonly ResetUserPasswordUseCase $resetUserPassword) {}

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function reset(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $this->resetUserPassword->handle($user->getKey(), $input['password']);
    }
}
