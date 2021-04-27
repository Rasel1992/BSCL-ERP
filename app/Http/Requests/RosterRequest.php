<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RosterRequest extends FormRequest
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
            'user_id' => 'nullable|array',
            'user_id.*' => 'required|integer',
            'shift_id' => 'nullable|array',
            'shift_id.*' => 'required|integer',
            'roster_date' => 'required|date',
            'day' => 'nullable|array',
            'day.*' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
        ];
    }
}
