<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Traits\ApiResponser;

class BookController extends Controller {
    use ApiResponser;
    public function index() {
        $books = Book::all();

        return $this->successResponse($books, 'Books retrieved successfully');
    }

    public function store(BookRequest $request) {
        $validatedData = $request->validated();

        $book = Book::create($validatedData);

        return response()->json($book, 201);
    }

    public function show($uuid) {
    $book = Book::where('uuid', $uuid)->first();

    if ($book) {
        return response()->json($book, 200);
    } else {
        return response()->json(['error' => 'Book not found'], 404);
    }
}

    public function update(BookRequest $request, $uuid) {
    $book = Book::where('uuid', $uuid)->first();

    if ($book) {
        $book->update($request->validated());
        return response()->json($book, 200);
    } else {
        return response()->json(['error' => 'Book not found'], 404);
    }
}

    public function destroy($uuid) {
    $book = Book::where('uuid', $uuid)->first();

    if ($book) {
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    } else {
        return response()->json(['error' => 'Book not found'], 404);
    }
    }
}