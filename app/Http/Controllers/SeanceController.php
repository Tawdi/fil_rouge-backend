<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreSeanceRequest;
use App\Http\Requests\UpdateSeanceRequest;
use App\Models\Seance;
use App\Services\SeanceService;
use Illuminate\Http\JsonResponse;

class SeanceController extends Controller
{
    public function __construct(private SeanceService $seanceService) {}

    public function index()
    {
        return Seance::with(['movie', 'room'])->get();
    }

    public function store(StoreSeanceRequest $request)
    {
        $seance = $this->seanceService->create($request->validated());
        return response()->json($seance, 201);
    }

    public function show($id) : JsonResponse
    {
        return response()->json($this->seanceService->findById($id));
    }

    public function update(UpdateSeanceRequest $request, Seance $seance)
    {
        $seance = $this->seanceService->update($seance, $request->validated());
        return response()->json($seance);
    }

    public function destroy(Seance $seance)
    {
        $this->seanceService->delete($seance);
        return response()->noContent();
    }
}
