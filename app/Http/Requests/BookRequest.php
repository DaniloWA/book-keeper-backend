<?php

namespace App\Http\Requests;

class BookRequest extends ApiMasterRequest
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
            'author_id' => 'required|exists:authors,id',
            'name' => 'required',
            'year' => 'required|integer',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'cover_img' => 'nullable|url',
            'pages' => 'required|integer',
            'description' => 'nullable',
            'country' => 'required|string',
        ];
    }
}
