<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    // GET /api/v1/cars
    public function index()
    {
        $cars = Car::all();
        return response()->json($cars);
    }

    // POST /api/v1/cars
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'make' => 'required',
            'model' => 'required',
            'colour' => 'required',
            'year' => 'required',
            'transmission' => 'required',
            'car_type' => 'required',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads/cars', 'public');
        } else {
            $path = null;
        }

        $car = Car::create([
            'description' => $request->description,
            'make' => $request->make,
            'model' => $request->model,
            'colour' => $request->colour,
            'year' => $request->year,
            'transmission' => $request->transmission,
            'car_type' => $request->car_type,
            'price' => $request->price,
            'photo' => $path,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Car created successfully', 'car' => $car], 201);
    }

    // GET /api/v1/cars/{car_id}
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return response()->json($car);
    }
}