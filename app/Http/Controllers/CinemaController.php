<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Models\Cinema;
use App\Services\AuthService;
use App\Services\CinemaService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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

    public function updateInfo(Request $request  )
    {
        
        $user = auth('api')->user();
        $cinema = $user->cinema ?? null;
    
        if (!$cinema || !$cinema->id) {
            abort(400, 'No cinema associated with this admin.');
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png,gif,webp|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            if ($cinema->image && Storage::disk('public')->exists($cinema->image)) {
                Storage::disk('public')->delete($cinema->image);
            }
    
            $imagePath = $request->file('image')->store('cinema_images', 'public');
            $validated['image'] = $imagePath;
        }

        $cinema = $this->cinemaService->update($cinema, $validated );
        return response()->json($cinema);
    }

    public function info(Request $request)
    {
        $user = auth('api')->user();
        $cinema = $user->cinema;
        if (!$cinema) {
            return response()->json([
                'message' => 'No cinema associated with this admin.'
            ], 404);
        }
        return response()->json([
            'cinema' => [
                'name' => $cinema->name,
                'address' => $cinema->address,
                'image' => $cinema->image,
            ],
            'admin' => [
                'email' => $user->email,
            ]
        ]);
    }

    public function updateAdminInfo(Request $request)
    {
        $user = auth('api')->user();
        $cinema = $user->cinema;
    
        if (!$cinema) {
            return response()->json([
                'message' => 'No cinema associated with this admin.'
            ], 404);
        }
    
        $validated = $request->validate([
            'email' => ['required','email',Rule::unique('users')->ignore($user->id),],
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['new_password'])) {
            if (!AuthService::changePassword($user, $validated['current_password'], $validated['new_password'])) {
                return response()->json([
                    'message' => 'Current password is wrong.'
                ], 403);
            }
        }


        $updatedUser = UserService::update($user->id, ["email"=> $validated["email"]]);
    
        return response()->json([
            'message' => 'Admin account updated successfully.',
            'user' => $updatedUser,
        ]);
    }

    public function cinemaData(Request $request ,$id)
    {
        $cinema = Cinema::findOrFail($id);
        $cinema['movies']=$this->cinemaService->inCinema($id);
        return response()->json($cinema); 
    }
}
