<?php
namespace App\Http\Controllers;


use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\ResponseFactory;

class UsuariosController
{

    private $mesesDoAno = array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

    /**
     * Display a listing of the resource.
     *
     * @param String $returnType
     *
     * @return \Illuminate\Http\Response
     */
    public function index($returnType = "view")
    {

        $usuarios = DB::table('usuarios')
            ->leftJoin('registros', 'registros.userid','=' ,'usuarios.id')
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

        $array = array("usuarios" => $usuarios);

        return $this->resposta($returnType, $array, 'usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param String $returnType
     * @return \Illuminate\Http\Response
     */

    public function show($id, $returnType = "view")
    {
        //$usuario = Usuario::find($id);
        $usuario = DB::table('usuarios')
            ->where('usuarios.id', '=', $id)
            ->leftJoin('registros', 'registros.userid','=' ,'usuarios.id')
            ->select('usuarios.id as id',
                'usuarios.email as email',
                'usuarios.nome as nome',
                'usuarios.sobrenome as sobrenome',
                DB::raw('count(registros.id) as total_registros'),
                DB::raw('TRUNCATE(IFNULL(AVG(registros.valor), 0), 2) as media_registros'))
            ->groupBy('usuarios.id',
                'usuarios.email',
                'usuarios.nome',
                'usuarios.sobrenome')
            ->get();

        $registros = DB::table('registros')
            ->select('registros.id as id',
                'registros.valor as valor',
                'registros.data as data',
                DB::raw('count(registros.id) as total_registros'))
            ->where('registros.userid', '=', $id)
            ->groupBy('registros.id',
                'registros.data',
                'registros.valor')
            ->get();

        $ganhosPorMes = array();
        $mesAtual = date("n");

        for($i = 1; $i<= $mesAtual; $i++){
            $resultado = DB::table('registros')
                ->select(DB::raw('TRUNCATE(IFNULL(SUM(registros.valor), 0), 2) as ganhosMes'),
                    DB::raw('TRUNCATE(IFNULL(AVG(registros.valor), 0), 2) as mediaMes'))
                ->where('userid', '=', $id)
                ->whereMonth('data', $i)
                ->get();
            array_push($ganhosPorMes, $resultado);
        }

        foreach ($registros as $registro) {
            $registro->valor = number_format($registro->valor, 2, ',', '.');
            $registro->data = date("d-m-Y", strtotime($registro->data));
        }

        $array = array("usuario" => $usuario, "registros" => $registros, "ganhosPorMes" => $ganhosPorMes, "mesesDoAno"=>$this->mesesDoAno);

        return $this->resposta($returnType, $array, $view='usuarios.show');
    }

    /**
     * Display the specified resource.
     *
     * @param String $returnType
     * @param array $array
     * @param String $view
     * @return \Illuminate\Http\Response
     */

    public function resposta($returnType, $array, $view = 'usuarios.index'){
        if($returnType == "json")
            return response()->json($array);
        else
            return view($view, $array);

    }

}