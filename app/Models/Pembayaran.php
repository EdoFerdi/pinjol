<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['tgl_bayar', 'jumlah_bayar','sisa_bayar', 'pinjaman_id', 'orang_id'];

    public function pinjamen(){
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id', 'id');
    }
    public function orang(){
        return $this->belongsTo(Orang::class, 'orang', 'id');
    }
}
