<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['tgl_pinjam', 'jumlah_pinjam', 'jangka_waktu', 'orang_id'];

    public function orang(){
        return $this->belongsTo(Orang::class, 'orang_id', 'id');
    }
}
