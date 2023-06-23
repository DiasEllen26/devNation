<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Niveis;

class Programadores extends Model
{
    use HasFactory;

    protected $fillable = ['nivel', 'nome', 'sexo', 'datanascimento', 'idade', 'hobby'];
    public function niveis()
    {
        $niveis = $this->belongsTo(Niveis::class, 'id');
        return $niveis;
    }
}
