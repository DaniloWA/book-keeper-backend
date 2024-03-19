<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use App\Traits\DefaultMessages;
use App\Traits\HtppResponseException;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ApiRegisterRequest extends FormRequest
{
    use ApiResponser;
    use HtppResponseException;
    use DefaultMessages;

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;

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
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return $this->defaultMessage();
    }

    protected function failedValidation(Validator $validator)
    {
        $this->HttpResponseException($validator, 422);
    }

}
