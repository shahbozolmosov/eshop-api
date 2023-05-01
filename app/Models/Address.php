<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'district_id', 'street', 'house', 'apartment', 'floor'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
