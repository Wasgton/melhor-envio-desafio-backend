<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'No file uploaded.',
        ];
    }
 
}
