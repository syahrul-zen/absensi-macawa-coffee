<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'tanggal',
        'jam_masuk_asli', 'latitude_masuk', 'longitude_masuk', 'jarak_masuk_meter',
        'jam_pulang_asli', 'latitude_pulang', 'longitude_pulang', 'jarak_pulang_meter',
        'foto_masuk', 'foto_pulang',
        'status', 'keterangan', 'file_izin'
    ];

    // Relasi: Data absen ini milik seorang karyawan
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
