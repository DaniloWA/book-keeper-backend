<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Book;
use App\Models\Review;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $query = Review::query();

        if ($request->has('is_positive')) {
            $isPositive = filter_var($request->input('is_positive'), FILTER_VALIDATE_BOOLEAN);
            $query->where('is_positive', $isPositive);
        }

        $reviews = $query->get();
        return $this->successResponse($reviews, 200);
    }

    public function store(ReviewRequest $request)
    {
        $validatedData = $request->validated();
        $book = Book::where('uuid', $validatedData['book_uuid'])->first();
        $validatedData['book_id'] = $book->id;
        $validatedData['user_id'] = Auth::id();
        $review = Review::create($validatedData);

        return $this->successResponse($review, 201);
    }

    public function show($id)
    {
        $review = Review::where('id', $id)->first();
        if ($review) {
            return $this->successResponse($review, 200);
        } else {
            return $this->errorResponse('Review not found', 404);
        }
    }

    public function update(ReviewRequest $request, $id)
    {
        $review = Review::where('id', $id)->first();
        if ($review) {
            $review->update($request->validated());
            return $this->successResponse($review, 200);
        } else {
            return $this->errorResponse('Review not found', 404);
        }
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)->first();
        if ($review) {
            $review->delete();
            return $this->successResponse([], "Review deleted successfully", 200);
        } else {
            return $this->errorResponse('Review not found', 404);
        }
    }
}
