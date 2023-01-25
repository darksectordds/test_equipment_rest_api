<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\Rule;

class RuleEquipmentTypeFindAndCheckMashSerialNumberByArray implements Rule
{
    /**
     * IDs from FormRequest.
     * 
     * @var array
     */
    private $equipment_type_ids;

    /**
     * Mask SN
     * 
     * @var string $mask
     */
    private $mask;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $equipment_type_ids)
    {
        $this->equipment_type_ids = $equipment_type_ids;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $key = explode('.', $attribute)[0];
        $equipment_type_id = $this->equipment_type_ids[$key];

        $equipment_type = EquipmentType::find($equipment_type_id);
        
        if (!$equipment_type) {
            $this->mask = null;
            return false;
        }

        $this->mask = $equipment_type->mask;

        return EquipmentType::checkMaskSN($value, $this->mask);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ($this->mask) ? "Equipment :attribute doesn't match mask $this->mask!" : "The selected :attribute is invalid.";
    }
}
