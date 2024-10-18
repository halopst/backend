<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Petugas extends Model
{
    use HasFactory;
    protected $fillable=['id_satker', 'nama_petugas', 'email_bps', 
            'email_google', 'nip_lama', 'no_hp', 'status', 'foto', 'jabatan', 'tampil',
            'hit', 'tanggal_diupdate', 'jenis_kelamin', 'nama_panggilan'];
   
    public function Satker(): BelongsTo
    {
        return $this->belongsTo(Satker::class, 'id_satker', 'id_satker');
    }

    public function konsultasi(): HasMany
    {
        return $this->hasMany(Konsultasi::class, 'id_petugas', 'id');
    }

    /**
     * image
     *
     * @return Attribute
     */
    protected function foto(): Attribute
    {
        return Attribute::make(
            // get: fn ($foto) => url('storage/back/' . $foto),
            get: function ($foto) {
                $defaultFotoMale = 'storage/back/petugas/halo_pst_male.png';
                $defaultFotoFemale = 'storage/back/petugas/halo_pst_female.png';
                $path = 'back/petugas/' . $foto;;
                
                //deploy  code
                //$path = 'storage/app/public/back/petugas/' . $foto;
                // dd($path);
                
                if (Storage::disk('public')->exists($path)) {
                    return url('storage/' . $path);
                }else if($this->jenis_kelamin === 1){
                    return url( $defaultFotoMale);
                }else{
                    return url($defaultFotoFemale);
                }

                //deploy  code
                // if (File::exists($path)) {
                //     return url($path);
                // }else if($this->jenis_kelamin === 1){
                //     return url( $defaultFotoMale);
                // }else{
                //     return url($defaultFotoFemale);
                // }
            }

        );
    }

    /**
    * The roles that belong to the Petugas
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function keahlian(): BelongsToMany
    {
        return $this->belongsToMany(Keahlian::class, 'petugas_keahlians','petugas_id','keahlians_id');
    }
}
