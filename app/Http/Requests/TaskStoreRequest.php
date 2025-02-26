<?php

namespace App\Http\Requests;

use App\Enum\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|required|min:3|max:255',
            'description' => 'string',
            'status' => [Rule::enum(TaskStatus::class)],
            'due_date' => 'date|date_format:Y-m-d|after:today',
        ];
    }
}
