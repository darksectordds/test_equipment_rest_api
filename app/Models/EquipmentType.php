<?php

namespace App\Models;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\EquipmentType
 *
 * @property int $id
 * @property string $name
 * @property string $mask
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Equipment[] $equipments
 * @property-read int|null $equipments_count
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType whereMask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EquipmentType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mask',
    ];

    /**
     * Equipments of type.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * Check serial number of product by mask.
     * 
     * @param string $serial
     * @param string $mask
     * @return bool
     */
    static public function checkMaskSN($serial, $mask) 
    {
        if (strlen($serial) != strlen($mask)) 
            return false;
        
        $regx = array(
            "N" => "[0-9]",
            "A" => "[A-Z]",
            "a" => "[a-z]",
            "X" => "[A-Z0-9]",
            "Z" => "[-|_|@]"
        );
        
        $mask_chars = str_split($mask);
        
        $output_regex = "/^";
        foreach ($mask_chars as $char) {
            $output_regex .= $regx[$char];
        }
        $output_regex .= "/";
        
        //dd($output_regex, $serial);

        return preg_match($output_regex, $serial) > 0;
    }
}
