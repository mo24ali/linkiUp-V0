<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    /** @use HasFactory<\Database\Factories\ReactionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'type',
        'reactable_id',
        'reactable_type'
    ];

        public function reactable()
    {
        return $this->morphTo();
    }
}
