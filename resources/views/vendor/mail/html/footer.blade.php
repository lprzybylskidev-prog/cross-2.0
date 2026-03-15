<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                    <p class="mail-shell__footer-meta">{{ __('mail.layout.signature') }}</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
