<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;
use App\Services\SeatService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeatRequest;

class SeatController extends Controller
{

    public function __construct(private SeatService $seatService) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeatRequest $request)
    {
        return response()->json($this->seatService->create($request->validated()), 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSeatRequest $request, Seat $seat)
    {
        return response()->json($this->seatService->update($seat, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seat $seat)
    {
        $this->seatService->delete($seat);
        return response()->json(null, 204);
    }

    public function getByRoom($roomId)
    {
        return response()->json($this->seatService->getByRoom($roomId));
    }
}