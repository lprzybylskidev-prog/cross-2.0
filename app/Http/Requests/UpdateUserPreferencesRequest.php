<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Cross\Domain\Localization\SystemLocale;
use Cross\Domain\Users\Preferences\UserTheme;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateUserPreferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'locale' => ['required', 'string', Rule::in(SystemLocale::values())],
            'theme' => ['required', 'string', Rule::in(UserTheme::values())],
        ];
    }
}
