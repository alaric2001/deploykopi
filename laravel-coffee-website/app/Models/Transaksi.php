<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'tbl_transaksi';
    protected $guarded = [];


    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat');
    }
}
