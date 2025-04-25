<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(UserRequest $request)
    {
        $user = $this->service->create($request->validated());
        return response()->json($user, 201);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->service->update($id, $request->validated());
        return response()->json($user);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:active,suspended,archived']);
        $user = $this->service->changeStatus($id, $request->status);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'User deleted']);
    }
}
