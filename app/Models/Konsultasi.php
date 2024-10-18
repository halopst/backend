<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Konsultasi extends Model
{
    use HasFactory;
    protected $fillable=[ 'tanggal_konsultasi', 'uuid','waktu_konsultasi', 
            'link_meeting', 'topik_diskusi', 'id_pengguna', 'id_petugas','id_satker', 'status', 
            'link_bukti', 'kritik_saran', 'rating','alasan_pembatalan', 'id_petugas_batal',
            'notif_flag','waktu_pengajuan', 'waktu_persetujuan', 'waktu_pembatalan','create_at','update_at'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
    
}
