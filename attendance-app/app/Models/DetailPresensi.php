<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPresensi extends Model
{
    use HasFactory;

    protected $table = 'detail_presensi';
    protected $primaryKey = 'id_detail_presensi';
    protected $fillable = ['presensi_id', 'id_murid', 'status'];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }

    public function presensi()
    {
        return $this->belongsTo(Presensi::class, 'presensi_id', 'id_presensi');
    }
}