<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'name' => 'nullable|string',
            'location' => 'nullable|string',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // Validate photo as an image
        ]);

        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos');
        }

        $user->update($validated);
        return response()->json($user);
    }

    public function addFavourite(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
        ]);

        $favourite = $user->favourites()->create($validated);
        return response()->json($favourite, 201);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function getFavourites($user_id)
    {
        $user = User::findOrFail($user_id);
        $favourites = $user->favourites()->with('car')->get()->pluck('car');
        return response()->json($favourites);
    }
}
