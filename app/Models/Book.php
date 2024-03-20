<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }


          /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'author_id' => 'integer',
            'name' => 'string',
            'year' => 'datetime:Y',
            'genre' => 'string',
            'cover_img' => 'string',
            'pages' => 'integer',
            'description' => 'string'          
        ];
      }
    
        public function author()
        {
            return $this->belongsTo(Author::class,'author_id','id');
        }

      
    }

