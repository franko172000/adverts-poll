<?php

namespace Franklin\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    use HasFactory;

    protected $fillable  = [
        'type',
        'amount',
        'currency'
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function rooms(){
        $this->belongsTo(Rooms::class, 'room_id', 'id');
    }
}
