<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EquipmentTypeSeeder extends Seeder
{
    protected $data = [
        ['name' => 'TP-Link TL-WR74', 'mask' => 'XXAAAAAXAA'],
        ['name' => 'D-Link DIR-300', 'mask' => 'NXXAAXZXaa'],
        ['name' => 'D-Link DIR-300 E', 'mask' => 'NAAAAXZXXX'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now();

        foreach($this->data as &$item) {
            $item['created_at'] = $timestamp;
            $item['updated_at'] = $timestamp;
        }

        EquipmentType::insert($this->data);
    }
}
