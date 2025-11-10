<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Search Request Validation
 * Follows Single Responsibility Principle - validation logic separated from controller
 */
class SearchRequest extends FormRequest
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
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'page' => ['sometimes', 'integer', 'min:1'],
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
            'per_page.integer' => 'Results per page must be a number.',
            'per_page.min' => 'Results per page must be at least 1.',
            'per_page.max' => 'Results per page cannot exceed 50.',
            'page.integer' => 'Page number must be a number.',
            'page.min' => 'Page number must be at least 1.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'q' => 'search query',
            'per_page' => 'results per page',
            'page' => 'page number',
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
     * Get the validated per_page parameter with default.
     */
    public function getPerPage(): int
    {
        return $this->validated()['per_page'] ?? 10;
    }

    /**
     * Get the validated page parameter with default.
     */
    public function getPage(): int
    {
        return $this->validated()['page'] ?? 1;
    }
}

