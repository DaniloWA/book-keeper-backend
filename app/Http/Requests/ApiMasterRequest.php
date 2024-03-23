<?php

namespace App\Http\Requests;

use App\Traits\ApiResponser;
use App\Traits\DefaultMessages;
use App\Traits\HtppResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ApiMasterRequest extends FormRequest
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
