<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegistrationForm extends FormRequest
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
            'name'=> 'required|max:60|min:2',
            'email' => 'required|email',
            'phone' => ['required','regex:/^\+380\d{9}$/'],
            'position_id' => 'required|integer',
            'photo' => 'required|image|mimes:jpg,jpeg|max:5120|dimensions:min_width=70,min_height=70'
        ];
    }
    public function messages()
    {
        return [
            'name.min' => 'The name must be at least 2 characters.',
            'email.email' => 'The email must be a valid email address.',
            'phone.required' => 'The phone field is required.',
            'phone.regex' => 'Phone number must start with +380 and contain 9 digits after it.',
            'position_id.integer' => 'The position id must be an integer.',
            'photo.max' => 'Photo may not be greater than 5 Mbytes.'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'fails' => $errors,
        ], 422));
    }
}
