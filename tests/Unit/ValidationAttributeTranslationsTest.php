<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;

it('uses localized validation attribute names in Polish', function (): void {
    app()->setLocale('pl');

    $validator = Validator::make(
        [],
        [
            'email' => ['required'],
            'current_password' => ['required'],
            'locale' => ['required'],
        ],
    );

    expect($validator->errors()->first('email'))
        ->toBe('Pole adres e-mail jest wymagane.')
        ->and($validator->errors()->first('current_password'))
        ->toBe('Pole aktualne hasło jest wymagane.')
        ->and($validator->errors()->first('locale'))
        ->toBe('Pole język aplikacji jest wymagane.');
});

it('uses localized validation attribute names in English', function (): void {
    app()->setLocale('en');

    $validator = Validator::make(
        [],
        [
            'email' => ['required'],
            'current_password' => ['required'],
            'theme' => ['required'],
        ],
    );

    expect($validator->errors()->first('email'))
        ->toBe('The email address field is required.')
        ->and($validator->errors()->first('current_password'))
        ->toBe('The current password field is required.')
        ->and($validator->errors()->first('theme'))
        ->toBe('The application theme field is required.');
});
