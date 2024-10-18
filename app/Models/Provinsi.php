<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $primaryKey = 'id_prov';
    protected  $fillable=['id_prov','nama_prov'];
}
