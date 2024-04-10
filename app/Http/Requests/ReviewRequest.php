<?php

namespace App\Http\Requests;

class ReviewRequest extends ApiMasterRequest
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
            'book_uuid' => 'required|exists:books,uuid',
            'title' => 'required|string|max:150',
            'content' => 'required|string|max:500'
        ];
    }
}
