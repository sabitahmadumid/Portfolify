<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'in:project,collaboration,consultation,support,other'],
            'budget' => ['nullable', 'string', 'in:under-5k,5k-10k,10k-25k,25k-50k,50k-plus,discuss'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your full name.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'subject.required' => 'Please select a subject.',
            'subject.in' => 'Please select a valid subject.',
            'budget.in' => 'Please select a valid budget range.',
            'message.required' => 'Please provide a message.',
            'message.min' => 'Message must be at least 10 characters.',
            'message.max' => 'Message cannot exceed 2000 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'full name',
            'email' => 'email address',
            'subject' => 'subject',
            'budget' => 'budget range',
            'message' => 'message',
        ];
    }
}
