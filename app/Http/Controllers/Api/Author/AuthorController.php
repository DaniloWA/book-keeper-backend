<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;

class AuthorController extends Controller{
   /**
    *
    *
    *  @return \Illuminate\Http\Client\Response 
    */
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }
    /**
    *
    *
    *  @return \Illuminate\Http\Client\Response 
    */

    //Seeking Author
    public function show($id)
    {
        $author = Author::where('id', $id)-> first();
       
        if ($author){
            return response()->json($author, 200);
        }
        else{
            return response()->json(['error' => 'Author not found'],404);
        }
    }

       
     //Controller creates a new author
    public function store(AuthorRequest $request)
     {
        $validatedData = $request->validated();

        $author = Author::create($validatedData);

        return response()->json($author, 201);
     }

     //Updates the data   
    public function update(AuthorRequest $request, $id) 
     {
            $author = Author::where('id', $id)->first();
        
            if ($author) {
              $author->update($request->validated());
              return response()->json($author, 200);
             } 
            else {
             return response()->json(['error' => 'Author not found'], 404);
            }
     }
           
     // Driver removes the author      
    public function destroy($id)
     {
          $author = Author::where('id', $id)->first();
            
         if ($author)  {
               
                  $author->delete();
                   
                  return response()->json(['message' => 'Author deleted successfully'], 200);
                } 
          else {
                 return response()->json(['error' => 'Author not found'], 404);
                }
                
      }   
}
   
     