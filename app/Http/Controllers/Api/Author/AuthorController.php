<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Traits\ApiResponser;

class AuthorController extends Controller{
    use ApiResponser;
    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors, 200);
    }

    public function show($id)
    {
        $author = Author::where('id', $id)-> first();
        if ($author) {
            return $this->successResponse($author, 200);
        } else {
            return $this->errorResponse( 'Author not found', 404);
        }
    }

    public function store(AuthorRequest $request)
    {
        $validatedData = $request->validated();
        $author = Author::create($validatedData);
        return $this->successResponse($author, 201);
    }

    public function update(AuthorRequest $request, $id)
    {
        $author = Author::where('id', $id)->first();
        if ($author) {
            $author->update($request->validated());
            return $this->successResponse($author, 200);
        } else {
            return $this->errorResponse('Author not found', 404);
        }
    }

    public function destroy($id){

        $author = Author::where('id', $id)->first();
        if ($author) {
            $author->delete();
            return $this->successResponse( 'Author deleted successfully', 200);
        } else {
            return $this->errorResponse('Author not found', 404);
        }

    }
}
