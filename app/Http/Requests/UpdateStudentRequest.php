<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isAdmin() || $this->user()->isTeacher());
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $studentId = $student instanceof User ? $student->id : $student;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($studentId),
            ],
            'parent_id' => ['nullable', 'exists:users,id'],
            'teacher_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
