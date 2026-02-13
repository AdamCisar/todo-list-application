<?php

namespace App\Features\Todo\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class TodoRequest extends FormRequest
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
        return match ($this->method()) {
            Request::METHOD_GET => [
                'status' => ['sometimes', 'in:completed'],
                'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            ],
            Request::METHOD_POST => [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['sometimes', 'string'],
                'completed' => ['sometimes', 'boolean'],
            ],
            Request::METHOD_PUT => [
                'title' => ['sometimes', 'string', 'max:255'],
                'description' => ['sometimes', 'string'],
                'completed' => ['sometimes', 'boolean'],
            ],
            default => [],
        };
    }
}
