<?php

namespace App\Http\Requests;

use App\Enums\TaskState;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', new Enum(TaskState::class)],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'type' => ['required', 'in:simple,timed,approval'],
            'due_at' => ['required', 'date', 'after:now'],
        ];
    }
}
