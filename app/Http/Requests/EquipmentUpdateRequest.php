<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RuleEquipmentTypeFindAndCheckMashSerialNumber;

class EquipmentUpdateRequest extends FormRequest
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
            //'equipment_type_id' => 'required|exists:equipment_type,id',
            'serial_number' => ['required', new RuleEquipmentTypeFindAndCheckMashSerialNumber($this->get('equipment_type_id'))],
            'comment' => 'sometimes|string|max:256',
        ];
    }
}
