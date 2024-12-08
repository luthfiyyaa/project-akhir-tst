<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kelas'];

    // Relasi ke murid
    public function murid()
    {
        return $this->hasMany(Murid::class, 'kelas_id');
    }

    // Relasi ke presensi
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'kelas_id');
    }
}