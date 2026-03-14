@component('mail::message')
    <div style="padding: 8px 0 24px">
        <div
            style="
                display: inline-block;
                border-radius: 999px;
                padding: 6px 12px;
                background: #313244;
                color: #89b4fa;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            "
        >
            Cross 2.0
        </div>

        <h1 style="margin: 20px 0 12px; font-size: 28px; line-height: 1.2; color: #cdd6f4">
            {{ __('mail.team_invitation.headline', ['team' => $invitation->team->name]) }}
        </h1>
    </div>

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        <p style="margin: 0 0 16px; color: #bac2de; line-height: 1.7">
            {{ __('mail.team_invitation.intro_with_registration') }}
        </p>

        @component('mail::button', ['url' => route('register')])
            {{ __('mail.team_invitation.create_account') }}
        @endcomponent

        <p style="margin: 20px 0 16px; color: #bac2de; line-height: 1.7">
            {{ __('mail.team_invitation.existing_account') }}
        </p>
    @else
        <p style="margin: 0 0 16px; color: #bac2de; line-height: 1.7">
            {{ __('mail.team_invitation.intro_without_registration') }}
        </p>
    @endif

    @component('mail::button', ['url' => $acceptUrl])
        {{ __('mail.team_invitation.accept_invitation') }}
    @endcomponent

    <p style="margin: 24px 0 0; color: #9399b2; line-height: 1.7">
        {{ __('mail.team_invitation.outro') }}
    </p>
@endcomponent
