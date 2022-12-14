<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $table = 'airlines';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'city',
        'image_path'
    ];

    public function flights() {
        return $this->hasMany(Flight::class, 'airline_id');
    }
}
