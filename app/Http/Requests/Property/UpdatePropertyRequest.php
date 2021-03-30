<?php

namespace App\Http\Requests\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
            "address" => "string",
            "bedrooms" => "numeric",
            "bathrooms" => "numeric",
            "total_area" => "numeric",
            "purchased" => "boolean",
            "value" => "",
            "discount" => "numeric",
            "owner_id" => "numeric",
            "expired" => "boolean",
        ];
    }
}
