<?php

declare(strict_types=1);

return [
    'common' => [
        'email' => 'E-mail',
        'password' => 'Hasło',
        'name' => 'Nazwa',
        'and' => 'oraz',
        'save' => 'Zapisz',
        'saved' => 'Zapisano.',
        'cancel' => 'Anuluj',
        'close' => 'Zamknij',
        'confirm' => 'Potwierdź',
        'create' => 'Utwórz',
        'created' => 'Utworzono.',
        'delete' => 'Usuń',
        'add' => 'Dodaj',
        'remove' => 'Usuń',
        'leave' => 'Opuść',
        'done' => 'Gotowe.',
        'enable' => 'Włącz',
        'disable' => 'Wyłącz',
        'dismiss' => 'Zamknij komunikat',
        'unknown' => 'Nieznane',
        'status' => [
            'granted' => 'Przyznany',
            'denied' => 'Odrzucony',
        ],
    ],
    'flash' => [
        'preferences_updated' => 'Preferencje zostały zaktualizowane.',
    ],
    'language' => [
        'application' => 'Język aplikacji',
        'polish' => 'Polski',
        'english' => 'Angielski',
    ],
    'theme' => [
        'dark' => 'Ciemny',
        'light' => 'Jasny',
        'system' => 'Systemowy',
    ],
    'nav' => [
        'debtors' => 'Dłużnicy',
        'profile' => 'Profil',
        'api_tokens' => 'Tokeny API',
        'logout' => 'Wyloguj',
    ],
    'app' => [
        'workspace' => 'Przestrzeń operacyjna',
        'signed_as' => 'Zalogowano jako :name',
        'dashboard' => 'Panel biznesowy',
        'footer' => [
            'copyright' => 'Prawa autorskie © :year Cross Finance SA',
        ],
    ],
    'debtors' => [
        'title' => 'Dłużnicy',
    ],
    'auth' => [
        'layout' => [
            'subtitle' => 'Kompleksowy system windykacyjny',
            'eyebrow' => 'Logowanie',
            'title' => 'Cross 2.0 to kompleksowy system windykacyjny do pracy operacyjnej zespołu.',
            'description' =>
                'System porządkuje codzienną pracę, dostęp do danych i obsługę procesów w jednym, spójnym środowisku biznesowym przygotowanym do dalszego rozwoju.',
            'operations_title' => '1. Konto tworzy administrator',
            'operations_description' =>
                'Dostęp do systemu jest nadawany centralnie. Jeśli nie masz konta, skontaktuj się z administratorem.',
            'security_title' => '2. Aktywuj konto z e-maila',
            'security_description' =>
                'Po utworzeniu konta otrzymasz wiadomość potrzebną do potwierdzenia adresu e-mail i aktywacji dostępu.',
            'localization_title' => '3. Ustaw hasło i zaloguj się',
            'localization_description' =>
                'Po zakończeniu aktywacji ustawiasz własne hasło i dopiero wtedy możesz wejść do panelu.',
        ],
        'login' => [
            'title' => 'Zaloguj się',
            'description' => 'Użyj danych dostępowych, aby wejść do przestrzeni operacyjnej.',
            'remember' => 'Zapamiętaj mnie',
            'forgot_password' => 'Nie pamiętasz hasła?',
            'submit' => 'Zaloguj',
        ],
        'forgot_password' => [
            'title' => 'Reset hasła',
            'description' => 'Odzyskaj dostęp do konta.',
            'helper' => 'Podaj adres e-mail, a wyślemy link do ustawienia nowego hasła.',
            'submit' => 'Wyślij link resetujący',
        ],
        'confirm_password' => [
            'title' => 'Potwierdź hasło',
            'description' => 'Potwierdzenie wejścia do chronionej sekcji.',
            'helper' => 'Potwierdź hasło przed przejściem dalej.',
            'submit' => 'Potwierdź',
        ],
        'register' => [
            'title' => 'Utwórz konto',
            'description' => 'Utwórz nowe konto dla swojej przestrzeni zespołowej.',
            'password_confirmation' => 'Potwierdź hasło',
            'terms_prefix' => 'Akceptuję',
            'login_link' => 'Masz już konto?',
            'submit' => 'Utwórz konto',
        ],
        'reset_password' => [
            'title' => 'Ustaw nowe hasło',
            'description' => 'Wybierz nowe hasło dla swojego konta.',
            'submit' => 'Zapisz nowe hasło',
        ],
        'verify_email' => [
            'title' => 'Potwierdź adres e-mail',
            'description' => 'Zatwierdź adres e-mail przed dalszą pracą.',
            'helper' =>
                'Sprawdź skrzynkę i potwierdź adres e-mail. Jeśli wiadomość nie dotarła, możemy wysłać nowy link.',
            'resent' => 'Nowy link weryfikacyjny został wysłany na Twój adres e-mail.',
            'submit' => 'Wyślij ponownie link weryfikacyjny',
            'edit_profile' => 'Edytuj profil',
        ],
    ],
    'legal' => [
        'privacy' => [
            'title' => 'Polityka prywatności',
            'description' => 'Aktualne zasady prywatności dla systemu Cross.',
        ],
        'terms' => [
            'title' => 'Warunki korzystania',
            'description' => 'Aktualne warunki korzystania z systemu Cross.',
        ],
    ],
    'profile' => [
        'title' => 'Profil',
        'overview' => [
            'title' => 'Dane użytkownika',
            'description' => 'Sprawdź dane konta używane w systemie.',
            'account_label' => 'Konto użytkownika',
            'email_verified' => 'Adres e-mail potwierdzony',
            'email_unverified' => 'Adres e-mail oczekuje na potwierdzenie',
            'fields' => [
                'name' => 'Nazwa użytkownika',
                'email' => 'Adres e-mail',
            ],
        ],
        'password' => [
            'title' => 'Aktualizacja hasła',
            'description' =>
                'Używaj silnego hasła, aby utrzymać wysoki poziom bezpieczeństwa konta.',
            'current' => 'Aktualne hasło',
            'new' => 'Nowe hasło',
        ],
    ],
    'teams' => [
        'common' => [
            'owner' => 'Właściciel zespołu',
            'name' => 'Nazwa zespołu',
        ],
        'create' => [
            'title' => 'Nowy zespół',
            'details_title' => 'Szczegóły zespołu',
            'details_description' => 'Utwórz nowy zespół do współpracy i pracy operacyjnej.',
        ],
        'settings' => [
            'title' => 'Ustawienia zespołu',
            'name_title' => 'Nazwa zespołu',
            'name_description' => 'Zmień nazwę zespołu i sprawdź dane właściciela.',
        ],
        'members' => [
            'add_title' => 'Dodaj członka zespołu',
            'add_description' => 'Zaproś nową osobę do współpracy w tym zespole.',
            'add_helper' => 'Podaj adres e-mail osoby, która ma zostać dodana do zespołu.',
            'role' => 'Rola',
            'added' => 'Dodano.',
            'pending_title' => 'Oczekujące zaproszenia',
            'pending_description' =>
                'Zaproszone osoby mogą dołączyć do zespołu po zaakceptowaniu wiadomości e-mail.',
            'list_title' => 'Członkowie zespołu',
            'list_description' => 'Wszystkie osoby aktualnie przypisane do tego zespołu.',
            'manage_role_title' => 'Zarządzaj rolą',
            'leave_title' => 'Opuść zespół',
            'leave_description' => 'Czy na pewno chcesz opuścić ten zespół?',
            'remove_title' => 'Usuń członka zespołu',
            'remove_description' => 'Czy na pewno chcesz usunąć tę osobę z zespołu?',
        ],
        'delete' => [
            'title' => 'Usuń zespół',
            'description' => 'Trwale usuń ten zespół.',
            'helper' =>
                'Usunięcie zespołu bezpowrotnie usuwa wszystkie powiązane zasoby i dane. Pobierz potrzebne informacje przed kontynuowaniem.',
            'submit' => 'Usuń zespół',
            'modal_title' => 'Usuń zespół',
            'modal_description' =>
                'Czy na pewno chcesz usunąć ten zespół? Ta operacja bezpowrotnie usuwa powiązane dane.',
        ],
    ],
    'api' => [
        'title' => 'Tokeny API',
        'permissions' => 'Uprawnienia',
        'create' => [
            'title' => 'Utwórz token API',
            'description' =>
                'Pozwól zewnętrznym usługom uwierzytelniać się przy użyciu dedykowanych tokenów.',
        ],
        'manage' => [
            'title' => 'Zarządzaj tokenami API',
            'description' => 'Przeglądaj i usuwaj tokeny, które nie są już potrzebne.',
            'last_used' => 'Ostatnie użycie :time',
        ],
        'token_value' => [
            'title' => 'Token API',
            'description' =>
                'Skopiuj nowy token API teraz. Ze względów bezpieczeństwa nie będzie pokazany ponownie.',
        ],
        'permissions_modal' => [
            'title' => 'Uprawnienia tokenu API',
        ],
        'delete' => [
            'title' => 'Usuń token API',
            'description' => 'Czy na pewno chcesz usunąć ten token API?',
        ],
    ],
];
