<?php
namespace App\Http\Controllers;


use App\Usuario;
use Illuminate\Support\Facades\DB;

class UsuariosController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = DB::table('usuarios')
            ->join('registros', 'userid', '=', 'usuarios.id')
            ->select('usuarios.id as id',
                     'usuarios.email as email',
                     'usuarios.nome as nome',
                     'usuarios.sobrenome as sobrenome',
                     DB::raw('count(registros.id) as total_registros'))
            ->groupBy('usuarios.id',
                      'usuarios.email',
                      'usuarios.nome',
                      'usuarios.sobrenome')
            ->get();

        return view('usuarios.index',compact('usuarios'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuarios = DB::table('usuarios')
            ->where('id', $id)
            ->join('registros', 'userid', '=', 'usuarios.id')
            ->select('usuarios.id as id',
                'usuarios.email as email',
                'usuarios.nome as nome',
                'usuarios.sobrenome as sobrenome',
                DB::raw('count(registros.id) as total_registros'))
            ->groupBy('usuarios.id',
                'usuarios.email',
                'usuarios.nome',
                'usuarios.sobrenome')
            ->get();
        return view('usuarios.show',compact('usuarios'));
    }

}