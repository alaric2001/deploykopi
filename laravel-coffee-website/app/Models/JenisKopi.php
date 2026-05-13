<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKopi extends Model
{
    use HasFactory;
    protected $table = 'tbl_jenis_kopi';
    protected $guarded = [];

    public function kopi()
    {
        return $this->belongsTo(Kopi::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function raw_jeniskopi()
    {
        return $this->belongsTo(RawJenisKopi::class, 'id_rawjeniskopi');
    }
}
