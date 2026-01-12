<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugadora extends Model {
    use HasFactory;
    protected $fillable = ['nom', 'equip_id', 'data_naixement', 'dorsal', 'foto'];

    public function equip() {
        return $this->belongsTo(Equip::class);
    }
}
