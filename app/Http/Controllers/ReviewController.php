<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('images', 'user')->get();
        return view('reviews', compact('reviews'));
    }

    public function show()
    {
        return Review::with('images', 'user')->get();
    }

    public function store(Request $request)
    {
        $review = Review::create([
            'user_id' => Auth::id(),
            'text' => $request->text
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images');
                Image::create([
                    'review_id' => $review->id,
                    'file_name' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        return response()->json($review->load('images', 'user'), 201);
    }
}
