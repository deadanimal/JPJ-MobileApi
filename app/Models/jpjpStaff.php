<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\jpjpBahagian;

class jpjpStaff extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    public $table = "staff";

   public function bahagian()
   {
       return $this->hasOne(jpjpBahagian::class,'kod','bahagian');
   }
}
