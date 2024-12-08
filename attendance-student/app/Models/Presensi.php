<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi'; // Nama tabel di database
    protected $primaryKey = 'id_presensi';
    protected $fillable = ['id_presensi', 'kelas_id', 'tanggal', 'created_at', 'updated_at'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);  // Menghubungkan dengan model Murid
    }


}