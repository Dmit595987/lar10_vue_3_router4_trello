<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DeskStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:desks,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'обязательное поле',
            'name.string' => 'должно быть строкой',
            'name.unique' => 'Такое значение уже есть, создайте уникальное'
        ];
    }
}
