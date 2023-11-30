<?php

namespace App\Http\Requests\Auth;

use App\Rules\CustomPasswordRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class NewPasswordResetRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'enrollment' => 'sometimes',
            'status' => 'required|boolean',
            'company_uuid' => 'required|uuid',
            'password' => [
                'required',
                'min:6',
                'max:20',
                'confirmed',
                new CustomPasswordRule(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O campo E-mail deve ser um endereço de e-mail válido.',
            'email.exists' => 'O e-mail informado não existe em nosso sistema.',
            'password.required' => 'O campo Senha é obrigatório.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.max' => 'A senha não pode ter mais de :max caracteres.',
        ];
    }
}
