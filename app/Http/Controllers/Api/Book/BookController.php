<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Traits\ApiResponser;

class BookController extends Controller
{
    use ApiResponser;
    public function index()
    {
        $books = Book::all();

        return $this->successResponse($books, 'Books retrieved successfully');
    }

    public function store(BookRequest $request)
    {
        $validatedData = $request->validated();

        $book = Book::create($validatedData);

        return $this->successResponse($book, 'Book created successfully', 201);
    }

    public function show($uuid)
    {
        $book = Book::where('uuid', $uuid)->first();

        if ($book) {
            return $this->successResponse($book, 'Book retrieved successfully', 200);
        } else {
            return $this->errorResponse('Book not found', 404);
        }
    }

    public function update(BookRequest $request, $uuid)
    {
        $book = Book::where('uuid', $uuid)->first();

        if ($book) {
            $book->update($request->validated());
            return $this->successResponse($book, 'Book updated successfully', 200);
        } else {
            return $this->errorResponse('Book not found', 404);
        }
    }

    public function destroy($uuid)
    {
        $book = Book::where('uuid', $uuid)->first();

        if ($book) {
            $book->delete();
            return $this->successResponse([], 'Book deleted successfully', 204);
        } else {
            return $this->errorResponse('Book not found', 404);
        }
    }
}
