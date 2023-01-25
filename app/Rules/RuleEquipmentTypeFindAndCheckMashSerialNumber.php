<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\Rule;

class RuleEquipmentTypeFindAndCheckMashSerialNumber implements Rule
{

    /**
     * ID of equipment_type.
     * 
     * @var int $equipment_type_id
     */
    private $equipment_type_id;

    /**
     * Mask SN
     * 
     * @var string $mask
     */
    private $mask;

    /**
     * Create a new rule instance.
     *
     * @param int $equipment_type_id
     * @return void
     */
    public function __construct(int $equipment_type_id)
    {
        $this->equipment_type_id = $equipment_type_id;
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
        $equipment_type = EquipmentType::find($this->equipment_type_id);
        
        if (!$equipment_type)
            return false;

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
