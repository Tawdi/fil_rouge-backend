<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function __construct(protected MovieService $movieService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Movie::query();
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('titre', 'ILIKE', "%{$search}%");
        }

        if ($request->has('genre_id')) {
            $query->where('genre_id', $request->input('genre_id'));
        }

        if ($request->has('rating')) {
            $query->where('rating', '>=', $request->input('rating'));
        }

        if ($request->has('release_date')) {
            $query->where('release_date', '>=', $request->input('release_date'));
        }

        $movies = $query->with('genre')->paginate(12);

        return response()->json($movies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): JsonResponse
    {
        $movie = $this->movieService->create($request->validated());
        return response()->json($movie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): JsonResponse
    {
        return response()->json($movie->load('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $movie = $this->movieService->update($movie, $request->validated());
        return response()->json($movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): JsonResponse
    {
        $this->movieService->delete($movie);
        return response()->json(null, 204);
    }
}
