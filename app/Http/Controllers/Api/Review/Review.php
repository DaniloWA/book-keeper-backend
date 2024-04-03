<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Controllers\Review;


class Review extends Controller
{


public function index(){


    $reviews = Review::all();
    return response()->json($reviews);
}
 /**
     * 
     *
     
     * @return \Illuminate\Http\Response
     */

public function store(ReviewRequest $request) {
    $validatedData = $request->validated();

    $review = Review::create($validatedData);

    return response()->json($review, 201);
}


public function show($id)
{
    $review = Review::where('id', $id)-> first();
   
    if ($review){
        return response()->json($review, 200);
    }
    else{
        return response()->json(['error' => 'Review not found'],404);
    }
}

  
     
public function update(ReviewRequest $request, $id) 
 {
     $review = Review::where('id', $id)->first();
        
      if ($review) {
          $review->update($request->validated());
         return response()->json($review, 200);
             } 
       else {
         return response()->json(['error' => 'Review not found'], 404);
            }
     }

    
public function destroy($id)
{
    $review  = Review ::where('id', $id)->first();
    
    if ($review )  {
        
            $review->delete();
            
            return response()->json(['message' => 'Review  deleted successfully'], 200);
        } 
    else {
            return response()->json(['error' => 'Review not found'], 404);
        }
        
} 
}
