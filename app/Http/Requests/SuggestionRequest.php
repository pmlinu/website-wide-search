<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Suggestion Request Validation
 * Follows Single Responsibility Principle - validation logic separated from controller
 */
class SuggestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['required', 'string', 'min:2', 'max:255'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:20'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'q.required' => 'Search query is required.',
            'q.min' => 'Search query must be at least 2 characters.',
            'q.max' => 'Search query cannot exceed 255 characters.',
            'limit.integer' => 'Limit must be a number.',
            'limit.min' => 'Limit must be at least 1.',
            'limit.max' => 'Limit cannot exceed 20.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'q' => 'search query',
            'limit' => 'suggestion limit',
        ];
    }

    /**
     * Get the validated query parameter.
     */
    public function getQuery(): string
    {
        return $this->validated()['q'];
    }

    /**
     * Get the validated limit parameter with default.
     */
    public function getLimit(): int
    {
        return $this->validated()['limit'] ?? 5;
    }
}

