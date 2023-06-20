<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Nivels;

class Programadores extends Model
{
    use HasFactory;

    protected $fillable = ['nivel', 'nome', 'sexo', 'datanascimento', 'idade', 'hobby'];

    public function niveis()
    {
        return $this->belongsTo(Niveis::class, 'nivel');
    }
}
