<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array $emails
 */
class ValidateEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'emails' => 'required|array',
            'emails.*.to' => 'required|email',
            'emails.*.subject' => 'required|string',
            'emails.*.body' => 'required|string',
        ];
    }
}
