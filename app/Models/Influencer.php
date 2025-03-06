<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Influencer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instagram_username',
        'followers_qty',
        'category',
    ];

    /**
     * Get the campaigns for the influencer.
     */
    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }
}
