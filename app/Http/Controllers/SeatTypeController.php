<?php

namespace App\Http\Controllers\Api;

use App\Models\SeatType;
use App\Services\SeatTypeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeatTypeRequest;

class SeatTypeController extends Controller
{
    public function __construct(private SeatTypeService $seatTypeService) {}

    public function index()
    {
        return response()->json($this->seatTypeService->all());
    }

    public function store(StoreSeatTypeRequest $request)
    {
        $seatType = $this->seatTypeService->create($request->validated());
        return response()->json($seatType, 201);
    }

    public function update(StoreSeatTypeRequest $request, SeatType $seatType)
    {
        $seatType = $this->seatTypeService->update($seatType, $request->validated());
        return response()->json($seatType);
    }

    public function destroy(SeatType $seatType)
    {
        $this->seatTypeService->delete($seatType);
        return response()->json(null, 204);
    }
}

