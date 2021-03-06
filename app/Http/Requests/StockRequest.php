<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'stock_code' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:stock_categories,id',
            'qty' => 'required|integer',
            'location' => 'required|in:hq,gs1,gs2',
            'stock_date' => 'required|date',
        ];
    }
}
