<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'karyawan_id', 'dokumen',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
