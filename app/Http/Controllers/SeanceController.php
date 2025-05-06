<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreSeanceRequest;
use App\Http\Requests\UpdateSeanceRequest;
use App\Models\Seance;
use App\Services\MovieService;
use App\Services\SeanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function getSeanceByCinema(Request $request){

        $user = auth('api')->user();
        if (!$user->isCinemaAdmin() || !$user->cinema) {
            return response()->json(['message' => 'You must be a cinema admin with an associated cinema'], 403);
        }

        $validated = $request->validate([
            'room_id'    => 'nullable|integer|exists:rooms,id',
            'movie_id'   => 'nullable|integer|exists:movies,id',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);
        try {
            $seances = $this->seanceService->getForSeanceCinema(
                $user->cinema->id,
                $validated
            );
            return response()->json($seances, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch seances: ' . $e->getMessage()], 500);
        }
        // return response()->json($this->seanceService->getForSeanceCinema($user->cinema->id));
    }

    public function seancesForMovie($movieId)
    {
        $movie = MovieService::findById($movieId);
        if(!$movie) return response()->json(['message'=>'Movie not found'],404);

        return  response()->json(["movie"=> $movie , "cinemas"=>$this->seanceService->getSeancesForMovie($movie->id)]);
    }
}
