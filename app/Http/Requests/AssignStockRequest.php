<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignStockRequest extends FormRequest
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
            'qty' => 'required|integer',
            'stock_id' => 'required|integer|exists:stocks,id',
            'assign_to' => 'required|in:user,department',
            'user_id' => 'nullable|integer|exists:users,id',
            'dept_id' => 'nullable|integer|exists:departments,id',
            'assign_date' => 'required|date',
        ];
    }
}
