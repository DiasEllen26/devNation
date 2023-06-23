<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Programadores;

class Niveis extends Model
{
    use HasFactory;

    protected $fillable = ['nivel'];


    public function programadores()
    {
        return $this->hasMany(Programadores::class);
    }
}
