<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /* Table Name */
    protected $table = 'profile';

    /* Primary Key */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'instagram',
        'facebook',
        'twitter',
        'is_public',
    ];

    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
        'user_id' => 'integer',
        'bio' => 'text',
        'avatar' => 'string',
        'instagram' => 'string',
        'facebook' => 'string',
        'twitter' => 'string',
        'is_public' => 'boolean',
            
        ];
    }

    protected $hidden = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
