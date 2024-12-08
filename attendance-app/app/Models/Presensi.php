<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';
    protected $fillable = ['kelas_id', 'tanggal'];

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class, 'presensi_id', 'id_presensi');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}