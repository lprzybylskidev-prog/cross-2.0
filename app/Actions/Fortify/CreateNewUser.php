<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use Cross\Application\Auth\Data\NewUserData;
use Cross\Application\Auth\RegisterNewUser;
use Cross\Domain\Users\ValueObjects\UserEmail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(private readonly RegisterNewUser $registerNewUser) {}

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

        $userId = $this->registerNewUser->handle(
            new NewUserData(
                name: $input['name'],
                email: new UserEmail($input['email']),
                password: $input['password'],
            ),
        );

        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        return $user;
    }
}
