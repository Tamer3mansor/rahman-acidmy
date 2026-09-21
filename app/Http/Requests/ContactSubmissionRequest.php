<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:255'],
            'parent_name' => ['required', 'string', 'max:255'],
            'student_age' => ['required', 'integer', 'min:3', 'max:80'],
            'phone' => ['required', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'array'],
            'schedule.*' => ['string'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
