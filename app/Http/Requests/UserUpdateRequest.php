<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string|min:3|max:50',
            'email' => [
                'sometimes',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->uuid, 'uuid'),
            ],
            'status' => 'sometimes|boolean',
            'enrollment' => 'sometimes',
            'company_uuid' => [
                'sometimes',
                'uuid',
                Rule::exists('companies', 'uuid'),
            ],
            'password' => 'nullable|min:6|max:20|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'name.string' => 'O campo Nome deve ser uma string.',
            'name.min' => 'O campo Nome deve ter pelo menos :min caracteres.',
            'name.max' => 'O campo Nome não pode ter mais de :max caracteres.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.string' => 'O campo E-mail deve ser uma string.',
            'email.lowercase' => 'O campo E-mail deve estar em letras minúsculas.',
            'email.email' => 'O campo E-mail deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo E-mail não pode ter mais de :max caracteres.',
            'email.unique' => 'O E-mail fornecido já está em uso.',
            'status.required' => 'O campo Status é obrigatório.',
            'status.boolean' => 'O campo Status deve ser verdadeiro (1) ou falso (0).',
            'company_uuid.required' => 'O campo Empresa é obrigatório.',
            'company_uuid.uuid' => 'O campo Empresa deve ser um UUID válido.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.max' => 'A senha não pode ter mais de :max caracteres.',
        ];
    }
}
