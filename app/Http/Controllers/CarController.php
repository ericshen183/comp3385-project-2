<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10); // Default to 10 if no limit is provided
        return response()->json(Car::latest()->take($limit)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'year' => 'required|integer',
            'transmission' => 'required|string',
            'car_type' => 'required|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|string',
        ]);
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $car = Car::create(array_merge($validated, ['user_id' => $user->id]));
        return response()->json($car, 201);
    }

    public function show($car_id)
    {
        $car = Car::findOrFail($car_id);
        return response()->json($car);
    }

    public function favourite($car_id)
    {
        $car = Car::findOrFail($car_id);
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $favourite = $car->favourites()->create(['user_id' => $user->id]);
        return response()->json($favourite, 201);
    }

    public function favouriteStatus($car_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $isFavourited = $user->favourites()->where('car_id', $car_id)->exists();
        return response()->json(['isFavourited' => $isFavourited]);
    }

    public function removeFavourite($car_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->favourites()->where('car_id', $car_id)->delete();
        return response()->json(['message' => 'Favourite removed successfully']);
    }
}
