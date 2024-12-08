<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Murid extends Authenticatable
{
    protected $table = 'murid'; // Sesuaikan dengan nama tabel yang ada di database
    protected $fillable = ['nama', 'kelas_id']; // Sesuaikan dengan kolom yang ada

    public function presensi()
    {
        return $this->hasMany(Presensi::class);  // Relasi one-to-many
    }

}
