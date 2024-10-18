<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Keahlian extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $fillable=['nama_keahlian', 'icon', 'tampilkan'];

    // /**
    //  * The roles that belong to the Keahlian
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function pengguna(): BelongsToMany
    // {
    //     return $this->belongsToMany(Pengguna::class, 'pengguna_keahlian');
    // }

    /**
    * The roles that belong to the Petugas
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function petugas(): BelongsToMany
    {
        return $this->belongsToMany(Petugas::class, 'petugas_keahlians','keahlians_id','petugas_id');
    }

    /**
     * image
     *
     * @return Attribute
     */
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn ($icon) => url('storage/back/keahlian/' . $icon),
            //deploy code
            //get: fn ($icon) => url('storage/app/public/back/keahlian/' . $icon),
        );
    }
}
