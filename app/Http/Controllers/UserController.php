<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RoleBasedScope; // Import your RoleBasedScope model
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Conditionally apply the scope if the route doesn't match the excluded ones
        if (!$request->is('api/users/*')) {
            $users = User::withoutGlobalScope(RoleBasedScope::class)->get();
        } else {
            $users = User::all(); // Apply the scope for other routes
        }

        return response()->json($users);
    }

    public function show(Request $request, $id)
    {
        // Conditionally apply the scope if the route doesn't match the excluded ones
        if (!$request->is('api/users/*')) {
            $user = User::withoutGlobalScope(RoleBasedScope::class)->findOrFail($id);
        } else {
            $user = User::findOrFail($id); // Apply the scope for other routes
        }

        return response()->json($user);
    }
}
