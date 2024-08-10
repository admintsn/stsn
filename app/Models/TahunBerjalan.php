<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunBerjalan extends Model
{
    use HasFactory;

    public function kelasSantris()
    {
        return $this->hasMany(KelasSantri::class);
    }

    public function pesandaftar()
    {
        return $this->belongsTo(PesanDaftar::class);
    }
}
