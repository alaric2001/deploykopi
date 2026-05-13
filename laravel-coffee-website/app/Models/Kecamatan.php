<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'tbl_kec';
    protected $guarded = [];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'id_kec');
    }
}
