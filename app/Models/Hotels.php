<?php

namespace Franklin\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'stars'
    ];

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'hotel_id', 'id');
    }
}
