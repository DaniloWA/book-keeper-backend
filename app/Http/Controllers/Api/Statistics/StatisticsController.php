<?php

namespace App\Http\Controllers\Api\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Models\Book;
use App\Traits\ApiResponser;

class StatisticsController extends Controller
{
    use ApiResponser;

    public function show($uuid)
    {
        if(!$book = Book::where('uuid', $uuid)->first()) {
            return $this->errorResponse('Book not found', 404);
        }

        $userStatistics = $book->statistics()->forCurrentUser()->select('status', 'liked')->get();
 
        if($userStatistics === null) {
            return $this->successResponse($userStatistics, 'Dont have any statistics for this book', 200);

        }

        return $this->successResponse($userStatistics, 'Statistics found', 200);
    }

    public function like($uuid)
    {
        if(!$book = Book::where('uuid', $uuid)->first()) {
            return $this->errorResponse('Book not found', 404);
        }

        $statistics = $book->statistics()->forCurrentUser()->first();

        $likedValue = $statistics ? !$statistics->liked : true;

        $book->statistics()->updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['liked' => $likedValue]
        );

        $message = $likedValue ? 'Book liked' : 'Book disliked';

        return $this->successResponse($book->statistics()->forCurrentUser()->select('status', 'liked')->get(), $message, 200);
    }

    public function changeStatus(StatusRequest $request, $uuid)
    {
        if(!$book = Book::where('uuid', $uuid)->first()) {
            return $this->errorResponse('Book not found', 404);
        }

        $book->statistics()->updateOrCreate(
            [
               'user_id' => auth()->user()->id,
            ],
            [
               'status' => $request->validated('status'),
            ]
        );

        $message =  'Book marked as ' .  $request->validated('status');

        return $this->successResponse($book->statistics()->forCurrentUser()->select('status', 'liked')->get(), $message, 200);
        
    }

}
