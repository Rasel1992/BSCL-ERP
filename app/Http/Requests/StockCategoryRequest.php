<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockCategoryRequest extends FormRequest
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
            'parent_id' => 'required|integer',
            'category_name' => $this->isMethod('put') ? 'required|string|max:100' : 'required|string|max:255|unique:stock_categories,category_name',
            'category_code' => $this->isMethod('put') ? 'nullable|string|max:100' : 'nullable|string|max:255|unique:stock_categories,category_code',
        ];
    }
}
