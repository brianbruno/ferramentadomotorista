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
        $status = 0;

        $usuario = DB::table('usuarios')
            ->where('usuarios.id', '=', $id)
            ->leftJoin('registros', 'registros.userid','=' ,'usuarios.id')
            ->select('usuarios.id as id',
                'usuarios.email as email',
                'usuarios.nome as nome',
                'usuarios.sobrenome as sobrenome',
                DB::raw('COUNT(registros.id) as total_registros'),
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

        $ranking = DB::table('usuarios')
            ->leftJoin('registros', 'registros.userid', '=', 'usuarios.id')
            ->select(DB::raw('COUNT(registros.id) as idRegistros'),
                'usuarios.id as id')
            ->groupBy('usuarios.id')
            ->orderBy('idRegistros', 'desc')
            ->get();

        $posicao = 0;

        for($i = 0; $i < sizeof($ranking); $i++){
            if($ranking[$i]->id == $id)
                $posicao = $i+1;
        }

        $status = 1;

        $array = array(
            "usuario"           => $usuario,
            "registros"         => $registros,
            "ganhosPorMes"      => $ganhosPorMes,
            "posicaoRanking"    => $posicao,
            "mesesDoAno"        => $this->mesesDoAno,
            "status"            => $status
        );

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

    /**
     *  Display the specified resource.
     *
     * @param int id
     * @param String $returnType
     *
     * @return \Illuminate\Http\Response
     */
    public function getData($id, $returnType = "json"){

        $status   = 0;
        $diaAtual = date("d");
        $mesAtual = date("n");
        $anoAtual = date('Y');

        $usuario = DB::table('usuarios')
            ->where('usuarios.id', '=', $id)
            ->leftJoin('registros', 'registros.userid','=' ,'usuarios.id')
            ->leftJoin('contas', 'contas.userid', '=', 'usuarios.id')
            ->leftJoin('meta', 'meta.userid', '=', 'usuarios.id')
            ->select('usuarios.id as id',
                'usuarios.email as email',
                'usuarios.nome as nome',
                'usuarios.sobrenome as sobrenome')
            ->groupBy('usuarios.id',
                'usuarios.email',
                'usuarios.nome',
                'usuarios.sobrenome')
            ->get();

        $dadosMes = DB::table('registros')
            ->select(DB::raw('IFNULL(SUM(registros.valor), 0) as ganhosMes'),
                DB::raw('TRUNCATE(IFNULL(AVG(registros.valor), 0), 2) as mediaMes'),
                DB::raw('COUNT(registros.id) as corridasMes'))
            ->whereMonth('registros.data', '=', $mesAtual)
            ->whereYear('registros.data', '=', $anoAtual)
            ->where('registros.userid', '=', $id)
            ->groupBy('registros.userid')
            ->get();

        $dadosDia = DB::table('registros')
            ->select(DB::raw('IFNULL(SUM(registros.valor), 0) as ganhosDia'),
                DB::raw('TRUNCATE(IFNULL(AVG(registros.valor), 0), 2) as mediaDia'),
                DB::raw('COUNT(registros.id) as corridasDia'))
            ->whereDay('registros.data', '=', $diaAtual)
            ->whereMonth('registros.data', '=', $mesAtual)
            ->whereYear('registros.data', '=', $anoAtual)
            ->where('registros.userid', '=', $id)
            ->groupBy('registros.userid')
            ->get();

        $dadosSemana = DB::table('registros')
            ->select(DB::raw('IFNULL(SUM(registros.valor), 0) as ganhosSemana'),
                DB::raw('TRUNCATE(IFNULL(AVG(registros.valor), 0), 2) as mediaSemana'),
                DB::raw('COUNT(registros.id) as corridasSemana'))
            ->whereDay('registros.data', '>=', $diaAtual-7)
            ->whereMonth('registros.data', '=', $mesAtual)
            ->whereYear('registros.data', '=', $anoAtual)
            ->where('registros.userid', '=', $id)
            ->groupBy('registros.userid')
            ->get();

        /*foreach ($usuario as $registro) {
            $registro->valor = number_format($registro->valor, 2, ',', '.');
            $registro->data = date("d-m-Y", strtotime($registro->data));
        }*/

        $status = 1;

        $array = array(
            "usuario"           => $usuario,
            "dadosMes "         => $dadosMes,
            "dadosDia"          => $dadosDia,
            "dadosSemana"       => $dadosSemana,
            "status"            => $status
        );

        var_dump($array);die;

        return $this->resposta($returnType, $array);



    }

}