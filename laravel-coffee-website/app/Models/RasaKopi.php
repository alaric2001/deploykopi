<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RasaKopi extends Model
{
    use HasFactory;
    protected $table = 'tbl_rasa_kopi';
    protected $guarded = [];

    public function kopi()
    {
        return $this->belongsTo(Kopi::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
