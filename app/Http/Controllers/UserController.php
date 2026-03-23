<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // CREATE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password'=>'required'
        ]);

        // $validated['password'] = bcrypt('123456');
        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    // READ
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'message' => 'User fetched successfully',
            'data' => $user
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name'  => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
