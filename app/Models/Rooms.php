<?php

namespace Franklin\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'code',
        'net_amount',
        'total_amount'
    ];

    protected $casts = [
        'total_amount' => 'float',
        'net_amount' => 'float',
    ];

    public function hotel(){
        return $this->belongsTo(Hotels::class, 'hotel_id', 'id');
    }

    public function taxes(){
        return $this->hasMany(Taxes::class, 'room_id', 'id');
    }
}
