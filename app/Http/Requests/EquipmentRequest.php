<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RuleEquipmentTypeFindAndCheckMashSerialNumberByArray;

class EquipmentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*' => 'array',
            //'*.equipment_type_id' => 'required|exists:equipment_type,id',
            '*.serial_number' => ['required', new RuleEquipmentTypeFindAndCheckMashSerialNumberByArray($this->input('*.equipment_type_id'), '*')],
            '*.comment' => 'sometimes|string|max:256',
        ];
    }
}
