<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['exists:users', 'email', 'required'],
            'token' => ['exists:password_resets,token', 'required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6', 'same:password'],
        ];
    }

    /**
     * Messages
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'email.exists' => 'This email is not associated with any user',
            'token.exists' => 'Token is invalid',
        ];
    }

}
