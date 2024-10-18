<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Aida extends Model
{
    use HasFactory;
    protected $fillable=[  'resume',
        'conversation','id_pengguna','status'
        ,'create_at','update_at'];

        public function pengguna(): BelongsTo
        {
            return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
        }
}
