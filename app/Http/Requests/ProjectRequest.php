<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:40', 'unique:users'],
            'role' => ['required', 'string'],
            'phone' => ['required', 'digits:10', 'unique:users'],
            'whatsapp' => ['max:10'],
            'adhar_number' => ['required', 'integer', 'digits:12', 'unique:users'],
            'pan_number' => ['max:10'],
            'total_experience' => ['required', 'string'],
            'job_profile' => ['required', 'string'],
        ];
    }
}
