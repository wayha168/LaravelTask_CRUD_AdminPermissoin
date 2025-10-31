<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Allow all users to make this request
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Validation rules for login
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',       // ✅ email is required and must be valid
            'password' => 'required|string',   // ✅ password is required
        ];
    }

    /**
     * Optional: Custom messages
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email.',
            'password.required' => 'Password is required.',
        ];
    }
}
