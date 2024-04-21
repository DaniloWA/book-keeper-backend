<?php

namespace App\Http\Controllers\Api\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use App\Traits\ApiResponser;

class GenreController extends Controller
{
    use ApiResponser;

    protected $genre;

    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    public function index()
    {
        $genres = $this->genre->all();

        return $this->successResponse($genres, 'Genres retrieved successfully', 200);
    }


    public function store(GenreRequest $request)
    {
        $payload = $request->validated();
        $genre = $this->genre->create($payload);
        return $this->successResponse($genre, 'Genre created successfully', 201);
    }


    public function show(string $id)
    {
        $genre = $this->genre->where('id', $id)->first();

        if (!$genre) {
            return $this->errorResponse('Genre not found', 404);
        }

        return $this->successResponse($genre, 'Genre retrieved successfully', 200);
    }


    public function update(GenreRequest $request, string $id)
    {
        $genre = $this->genre->where('id', $id)->first();

        if (!$genre) {
            return $this->errorResponse('Genre not found', 404);
        }

        $payload = $request->validated();
        $genre->update($payload);

        return $this->successResponse($genre, 'Genre updated successfully', 200);
    }


    public function destroy(string $id)
    {
        $genre = $this->genre->where('id', $id)->first();
        if (!$genre) {
            return $this->errorResponse('Genre not found', 404);
        }

        $genre->delete();

        return $this->successResponse([], 'Genre deleted successfully', 200);
    }
}
