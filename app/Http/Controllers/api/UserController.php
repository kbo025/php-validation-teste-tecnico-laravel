<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
/**
 * Display a listing of the resource.
 */
public function index(Request $request)
{
    $query = User::query();

    $name = $request->input('name');
    if ($name && strlen($name) > 0) {
        $query->where('name', 'ilike', '%' . $name . '%');
    }

    $email = $request->input('email');
    if ($email && strlen($email) > 0) {
        $query->where('email', 'ilike', '%' . $email . '%');
    }

    $active = $request->input('active');
    if ($active && strlen($active) > 0) {
        $query->where('active', $active === '1' ? true : false);
    }

    $users = $query->paginate($request->input('per_page', 15));

    return $users;
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => $request->active ?? true,
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'active' => 'sometimes|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $user->delete();
        return response()->json(['message' => 'User successfully deleted'], Response::HTTP_OK);
    }

    public function destroyBatch(Request $request)
    {
        $ids = $request->input('ids');

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'message' => 'Invalid input'
            ], Response::HTTP_BAD_REQUEST);
        }

        $deletedCount = User::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => "Successfully deleted $deletedCount users"
        ], Response::HTTP_OK);
    }
}
