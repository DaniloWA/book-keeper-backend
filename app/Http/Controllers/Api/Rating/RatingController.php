<?php

namespace App\Http\Controllers\Api\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Models\Book;
use App\Traits\ApiResponser;

class RatingController extends Controller
{
    use ApiResponser;

    public function rate($uuid, $rating = null)
    {
        if (!is_string($uuid)) {
            return $this->errorResponse('Book uuid must be a string', 400);
        }
        
        if(!$book = Book::where('uuid', $uuid)->first()) {
            return $this->errorResponse('Book not found', 404);
        }

        if($rating === null) {
            return $this->errorResponse('Rating must be provided', 400);
        }

        $rating = (int)$rating;

        if (!is_numeric($rating) || !is_integer($rating)) {
            return $this->errorResponse('Rating must be a number and an integer', 400);
        }


        if ($rating < 1 || $rating > 5) {
            return $this->errorResponse('Rating must be between 1 and 5', 400);
        }

        $book->rate($rating);

        return $this->successResponse(
            $book->
                rating()
                ->forCurrentUser()
                ->select('score')
                ->get(),
            'Book rated successfully',
            200
        );
    }
}
