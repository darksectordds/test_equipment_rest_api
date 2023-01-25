<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\EquipmentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentTypeResource;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name') ?? $request->get('q');
        $mask = $request->get('mask') ?? $request->get('q');

        $collection = EquipmentType::
            where(function($query) use ($name, $mask) {
                if ($name)
                    $query->where('name', 'LIKE', "%$name%");

                if ($mask)
                    $query->orWhere('mask', 'LIKE', "%$mask%");
            })
            ->paginate();

        return EquipmentTypeResource::collection($collection);
    }
}
