<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isAdmin() || $this->user()->isTeacher());
    }

    public function rules(): array
    {
        $parent = $this->route('parent');
        $parentId = $parent instanceof User ? $parent->id : $parent;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($parentId),
            ],
            'teacher_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
