<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employee_id' => 'required|nullable|string|max:255|unique:employees,employee_id',
            'first_name' => 'required|nullable|string|max:255',
            'last_name' => 'required|nullable|string|max:255',
            'department_id' => 'required|nullable|exists:departments,id',
        ];
    }
}
