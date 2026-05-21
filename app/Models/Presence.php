<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id', 'tanggal',
        'jam_masuk_asli', 'latitude_masuk', 'longitude_masuk', 'jarap_masuk_meter',
        'jam_pulang_asli', 'latitude_pulang', 'longitude_pulang', 'jarak_pulang_meter',
        'status', 'keterangan',
    ];

    // Relasi: Data absen ini milik seorang karyawan
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
