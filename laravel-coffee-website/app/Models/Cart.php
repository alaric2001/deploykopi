<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'tbl_cart';
    protected $guarded = [];

    public function kopi()
    {
        return $this->belongsTo(Kopi::class);
    }

    public function rasakopi()
    {
        return $this->belongsTo(RasaKopi::class, 'rasa_kopi_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
