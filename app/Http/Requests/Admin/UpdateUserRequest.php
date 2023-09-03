<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(request('uuid'), 'uuid')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6', 'same:password'],
            'avatar' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'is_marketing' => ['nullable', 'string'],
        ];
    }
}
