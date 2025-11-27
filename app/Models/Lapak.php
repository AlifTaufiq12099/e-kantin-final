<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapak extends Model
{
    use HasFactory;

    protected $primaryKey = 'lapak_id';
    protected $fillable = ['nama_lapak','pemilik','no_hp_pemilik'];
}
