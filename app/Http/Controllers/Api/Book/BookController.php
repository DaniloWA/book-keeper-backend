<?php

namespace App\Http\Controllers\Api\Book;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Services\BookService;

class BookController extends Controller
{
    use ApiResponser;

    protected $book;
    protected $service;

    public function __construct(Book $book, BookService $service)
    {
        $this->book = $book;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $allowedFilters = [
            'authors',
        ];

        $filters = $request->only($allowedFilters);

        $perPage = $request->input('per_page') ?? 10;
        $page = $request->input('page') ?? 1;
        
        $books = $this->service->getPaginatedBooks($filters, $perPage, $page);
 
        return $this->successResponse($books, 'Books retrieved successfully');
    }

    public function store(BookRequest $request)
    {
        $validatedData = $request->validated();

        $book = $this->book->create($validatedData);

        return $this->successResponse($book, 'Book created successfully', 201);
    }

    public function show($uuid)
    {
        $book = $this->book->where('uuid', $uuid)->first();

        if ($book) {
            return $this->successResponse($book, 'Book retrieved successfully', 200);
        } else {
            return $this->errorResponse('Book not found', 404);
        }
    }

    public function update(BookRequest $request, $uuid)
    {
        $book = $this->book->where('uuid', $uuid)->first();

        if ($book) {
            $book->update($request->validated());
            return $this->successResponse($book, 'Book updated successfully', 200);
        } else {
            return $this->errorResponse('Book not found', 404);
        }
    }

    public function destroy($uuid)
    {
        $book = $this->book->where('uuid', $uuid)->first();

        if ($book) {
            $book->delete();
            return $this->successResponse([], 'Book deleted successfully', 204);
        } else {
            return $this->errorResponse('Book not found', 404);
        }
    }
}
