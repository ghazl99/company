<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class userRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8), // Minimum length of 8 characters
                // ->mixedCase() // Must include both uppercase and lowercase letters
                // ->letters()   // Must include at least one letter
                // ->numbers()   // Must include at least one number
                // ->symbols()   // Must include at least one symbol
                // ->uncompromised(), // Checks against known data breaches
            ],
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'framework' => 'required|string|max:255',
            'cv' => 'nullable|file',
            'personal_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
