<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktiviti extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kedatangan()
    {
        return $this->belongsTo(Kedatangan::class,'id_aktiviti');
    }

    // public function sesi()
    // {
    //     return $this->hasOne(Sesi::class,'aktiviti_id');
    // }
}
