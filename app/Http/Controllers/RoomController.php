<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(private RoomService $roomService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user->isCinemaAdmin() || !$user->cinema) {
            return response()->json(['message' => 'You must be a cinema admin with an associated cinema'], 403);
        }

        return response()->json($this->roomService->all($user->cinema->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user->isCinemaAdmin() || !$user->cinema) {
            return response()->json(['message' => 'You must be a cinema admin with an associated cinema to create a room.'], 403);

        }
        $data = $request->validated();
        $data['cinema_id'] = $user->cinema->id;
        $room = $this->roomService->create($data);
        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->roomService->findById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user->isCinemaAdmin() || !$user->cinema) {
            return response()->json(['message' => 'You must be a cinema admin with an associated cinema to edit a room.'], 403);

        }
        if($user->cinema->id != $room->cinema_id){
            return response()->json(['message' => 'You cannot edit a room that does not belong to your cinema.'], 403);
        }

        $room = $this->roomService->update($room, $request->validated());
        return response()->json($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user->isCinemaAdmin() || !$user->cinema) {
            return response()->json(['message' => 'You must be a cinema admin with an associated cinema to delete a room.'], 403);
        }
        if($user->cinema->id != $room->cinema_id){
            return response()->json(['message' => 'You cannot delete a room that does not belong to your cinema.'], 403);
        }

        $this->roomService->delete($room);
        return response()->json(null, 204);
    }
}
