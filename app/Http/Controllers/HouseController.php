<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\House;
use Inertia\Inertia;
use Inertia\Response;

class HouseController extends Controller
{
    public function searchForm(): Response
    {
        return Inertia::render('House');
    }

    public function search(Request $request): JsonResponse
    {
        $data = $request->input();

        sleep(2);

        $request->validate([
            'name' => 'string|max:30|nullable',
            'bedrooms' => 'integer|digits_between:0, 2|nullable',
            'bathrooms' => 'integer|digits_between:0, 2|nullable',
            'storeys' => 'integer|digits_between:0, 2|nullable',
            'garages' => 'integer|digits_between:0, 2|nullable',
            'minPrice' => 'numeric|min:100000|nullable',
            'maxPrice' => 'numeric|gte:minPrice|nullable',
        ]);

        return response()->json(["success" => true, "houses" => House::selectListOfHouses($data)]);
    }
}
