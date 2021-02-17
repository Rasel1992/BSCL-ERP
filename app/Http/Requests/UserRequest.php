<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|in:admin,staff',
            'email' => $this->isMethod('put') ? 'nullable|string|max:100' : 'required|string|max:100',
            'password' => $this->isMethod('put') ? 'nullable|string|min:8|max:255' : 'required|string|min:8|max:255',
            'dob' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'dept_id' => 'required|integer|exists:departments,id',
            'designation' => 'required|string|max:255',
            'image' => 'nullable|image',
        ];
    }
}
