<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\User;
use Cross\Application\Teams\DeleteUser as DeleteUserUseCase;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    public function __construct(private readonly DeleteUserUseCase $deleteUser) {}

    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        $this->deleteUser->handle($user->getKey());
    }
}
