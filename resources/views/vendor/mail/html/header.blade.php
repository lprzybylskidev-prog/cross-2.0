@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" class="mail-shell__brand-link">
            <span class="mail-shell__eyebrow">{{ __('mail.layout.eyebrow') }}</span>
            <span class="mail-shell__brand">{!! $slot !!}</span>
        </a>
    </td>
</tr>
