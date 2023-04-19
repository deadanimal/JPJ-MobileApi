<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function aktiviti(){
    //     return $this->belongsTo(Aktiviti::class);
    // }
}
