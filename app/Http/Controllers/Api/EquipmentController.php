<?php

namespace App\Http\Controllers\Api;

use ReflectionClass;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\EquipmentResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EquipmentUpdateRequest;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return EquipmentResource
     */
    public function index(Request $request)
    {
        $equipment_type_id = $request->get('equipment_type_id') ?? $request->get('q');
        $comment = $request->get('comment') ?? $request->get('q');

        $collection = Equipment::with([
                'equipment_type'
            ])
            ->where(function($query) use ($equipment_type_id, $comment) {
                if ($equipment_type_id)
                    $query->where('equipment_type_id', $equipment_type_id);

                if ($comment)
                    $query->orWhere('comment', 'LIKE', "%$comment%");
            })
            ->paginate();

        return EquipmentResource::collection($collection);
    }

    /**
     * Display a single resource by id.
     * 
     * @param \Illuminate\Http\Request  $request
     * @param int $id
     * @return EquipmentResource
     */
    public function get(Request $request, int $id)
    {
        $object = Equipment::with([
                'equipment_type'
            ])
            ->where('id', $id)
            ->first();

        return new EquipmentResource($object);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // WARNING:
        // EquipmentRequest наследуется от FormRequest что прерывает выполнение
        // store метода в контроллере, если использовать type-hinting.
        // Есть ли вообще такое решение, при котором EquipmentRequest не
        // прерывает свое выполнение, если не проходит валидацию? Мб создатель ТЗ ошибся?
        // Делаю в лоб.

        $equipment_request = new EquipmentRequest($request->all());

        $validator = Validator::make($request->all(), $equipment_request->rules());
        $ungroup_errors = $validator->errors();
        $validated = $validator->valid();
        
        $success = [];
        foreach($validated as $item) {

            $equipment = Equipment::create([
                'equipment_type_id' => $item['equipment_type_id'],
                'serial_number' => $item['serial_number'],
                'comment' => $item['comment'] ?? null,
            ]);

            $success[] = new EquipmentResource(
                $equipment->load([
                    'equipment_type',
                ])
            );
        }
        
        $errors = (object)[];
        foreach($ungroup_errors->messages() as $ue_key=>$ue_val) {
            $arr_key = explode('.', $ue_key);
            $key = $arr_key[0];
            $val = $arr_key[1];

            $errors->{$key}[] = str_replace($ue_key, $val, $ue_val[0]);
        }

        return response()->json((object)[
            'errors' => $errors,
            'success' => $success,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EquipmentUpdateRequest $request
     * @param  Equipment  $equipment
     * @return EquipmentResource
     */
    public function update(EquipmentUpdateRequest $request, Equipment $equipment)
    {
        $equipment->update($request->all());

        return new EquipmentResource($equipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment  $equipment
     * @return EquipmentResource
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return new EquipmentResource($equipment);
    }
}
