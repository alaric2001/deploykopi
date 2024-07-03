<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kopi extends Model
{
    use HasFactory;
    protected $table = 'tbl_kopi';
    protected $guarded = [];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function rasakopi()
    {
        return $this->hasMany(RasaKopi::class);
    }
}
