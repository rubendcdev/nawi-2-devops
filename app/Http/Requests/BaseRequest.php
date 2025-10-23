<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $errors,
                'code' => 'VALIDATION_ERROR'
            ], 422)
        );
    }

    /**
     * Sanitize input data to prevent XSS attacks
     */
    protected function sanitizeInput(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                // Remove potentially dangerous characters
                $sanitized[$key] = strip_tags(trim($value));
                // Escape HTML entities
                $sanitized[$key] = htmlspecialchars($sanitized[$key], ENT_QUOTES, 'UTF-8');
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Get sanitized data
     */
    public function getSanitizedData(): array
    {
        return $this->sanitizeInput($this->validated());
    }
}
