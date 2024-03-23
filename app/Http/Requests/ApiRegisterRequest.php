<?php

namespace App\Http\Requests;

class ApiRegisterRequest extends ApiMasterRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'unique:users,email',
                'max:255'
            ],
            'username' => [
                'required',
                'string',
                'unique:users,username'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255'
            ],
        ];
    }
}
