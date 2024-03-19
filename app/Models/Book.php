<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    
    protected $table = 'books';
    
    protected $fillable = [  
     'uuid',
     'author_id',
     'name',
     'year',
     'genre',
     'cover_img',
     'pages',
     'description'
        ];

          /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'uuid' => 'integer',
            'author_id' => 'integer',
            'name' => 'string',
            'year' => 'datetime:Y',
            'genre' => 'string',
            'cover_img' => 'string',
            'pages' => 'integer',
            'description' => 'text'
            
        ];
      }
    
        public function author()
        {
            return $this->belongsTo(Author::class,'author_id','id');
        }

      
    }

