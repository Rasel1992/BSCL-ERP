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
            'user_id' => $this->isMethod('put') ? 'nullable|string|max:100' : 'required|string|max:100|unique:users,user_id',
            'type' => 'required|in:admin,staff',
            'email' => $this->isMethod('put') ? 'nullable|string|max:100' : 'required|string|max:100|unique:users,email',
            'mobile' => 'nullable|string|max:11|min:11',
            'password' => $this->isMethod('put') ? 'nullable|string|min:8|max:255' : 'required|string|min:8|max:255',
            'dob' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'dept_id' => 'required|integer|exists:departments,id',
            'designation' => 'required|string|max:255',
            'image' => 'nullable|image',
            'joining_date' => 'nullable|date',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255',
            'passport' => 'nullable|string|max:255',
            'present_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'signature' => 'nullable|image',
        ];
    }
}
