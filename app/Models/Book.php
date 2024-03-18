<?php


class Book extends model {
    
    use HasFactory;

    protected $table = 'book';

    protected $fillable = [  
     'uuid',
    'author_id',
    'name',
    'year',
    'gene',
    'cover_img',
    'pages',
    'description',];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}