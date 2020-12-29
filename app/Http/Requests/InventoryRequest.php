<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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
            'asset_code' => $this->isMethod('put') ? 'nullable|string|max:255' : 'required|string|unique:inventories|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'assign_to' => 'required|in:user,department',
            'user_id' => 'nullable|integer|exists:users,id',
            'dept_id' => 'nullable|integer|exists:departments,id',
            'voucher_no' => 'nullable|string|max:255',
            'qty' => 'nullable|integer',
            'cost' => 'nullable|numeric',
            'location' => 'required|in:hq,gs1,gs2',
            'purchase_date' => 'required|date',
        ];
    }
}
