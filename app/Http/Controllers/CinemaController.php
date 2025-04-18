<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Models\Cinema;
use App\Services\CinemaService;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function __construct(private CinemaService $cinemaService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->cinemaService->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCinemaRequest $request)
    {
        $cinema = $this->cinemaService->create($request->validated());
        return response()->json($cinema, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($this->cinemaService->findById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCinemaRequest $request, Cinema $cinema)
    {
        $cinema = $this->cinemaService->update($cinema, $request->validated());
        return response()->json($cinema);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cinema $cinema)
    {
        $this->cinemaService->delete($cinema);
        return response()->json(null, 204);
    }
}
