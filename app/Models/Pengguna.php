<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Pengguna extends Model
{
    use HasFactory;
    protected $fillable=[ 'nama_pengguna', 'email_google', 
            'family_name', 'given_name', 'foto', 'pekerjaan', 'jenis_kelamin', 
            'tanggal_lahir', 'id_prov', 'id_kab','nmr_telp', 'pendidikan', 'status' ];

    public function Provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'id_prov', 'id_prov');
    }
    public function Kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'id_kab', 'id_kab');
    }

    public function konsultasi(): HasMany
    {
        return $this->hasMany(Konsultasi::class, 'id_pengguna', 'id');
    }
    

    /**
     * image
     *
     * @return Attribute
     */
    protected function foto(): Attribute
    {
        return Attribute::make(
            get: fn ($foto) => url('storage/app/public/back/user/' . $foto),
        );
    }
}
