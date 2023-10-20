<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'color'
    ];

    public function communityLinks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityLink::class);
    }

}
