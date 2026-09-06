<?php

namespace App\Http\Requests;

use App\Enums\StudentLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email' => ['required', 'email', 'max:255'],
            'level' => ['required', Rule::enum(StudentLevel::class)],
            'schedule' => ['array'],
            'schedule.*' => ['string'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
