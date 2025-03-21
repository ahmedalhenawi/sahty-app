<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users',
            'password' => "required|confirmed|min:6",
            'is_doctor' => 'required|boolean',
            'jop_specialty_number' => 'required_if:is_doctor,true|string|max:6',
            'specialty_id' => 'required_if:is_doctor,true|numeric|exists:specialties,id',

        ];
    }
}
