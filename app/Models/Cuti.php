<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id', 'nama', 'nip',
        'divisi', 'tanggal_mulai', 'tanggal_berakhir',
        'jenis_cuti', 'alasan', 'bukti',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
    
}
