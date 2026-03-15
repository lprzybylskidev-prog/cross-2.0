<x-mail::message>
    # {{ __('mail.team_invitation.headline', ['team' => $invitation->team->name]) }}

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        {{ __('mail.team_invitation.intro_with_registration') }}

        <x-mail::button :url="route('register')">
            {{ __('mail.team_invitation.create_account') }}
        </x-mail::button>

        {{ __('mail.team_invitation.existing_account') }}
    @else
        {{ __('mail.team_invitation.intro_without_registration') }}
    @endif

    <x-mail::button :url="$acceptUrl">
        {{ __('mail.team_invitation.accept_invitation') }}
    </x-mail::button>

    {{ __('mail.team_invitation.outro') }}
</x-mail::message>
