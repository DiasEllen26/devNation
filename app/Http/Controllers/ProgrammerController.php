<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programadores;

class ProgrammerController extends Controller
{
    public function index()
    {
        return Programadores::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nivel' => 'required',
            'nome' => 'required',
            'sexo' => 'required',
            'datanascimento' => 'required',
            'idade' => 'required',
            'hobby' => 'required',
        ]);

        return Programadores::created($request->all());
    }

    public function show($id)
    {
        return Programadores::findOffail($id);
    }
}
