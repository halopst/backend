<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kabupaten extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $primaryKey = 'id_kab';
    protected $fillable=['id_kab','nama_kab','id_prov'];

    public function Provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'id_prov', 'id_prov');
    }
}
