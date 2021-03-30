<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreatePropertyRequest extends FormRequest
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
            "address" => "required|string",
            "bedrooms" => "required|numeric",
            "bathrooms" => "required|numeric",
            "total_area" => "required|numeric",
            "purchased" => "required|boolean",
            "value" => "required",
            "discount" => "required|numeric",
            "owner_id" => "required|numeric",
            "expired" => "required|boolean",
        ];
    }
}
