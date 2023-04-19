<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetiMasuk extends Model
{
    use HasFactory;

    protected $table = 'peti_masuk';
    protected $guarded = ['id'];
}
