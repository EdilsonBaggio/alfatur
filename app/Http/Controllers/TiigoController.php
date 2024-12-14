<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiigoController extends Controller
{
    public $grupos;

    public function index(){
        $onecode = new OneCodeController;
        $grupos = $onecode->getGruposByArray();

        return view('vincular-veiculos')->with(['grupos'=>$grupos]);
    }
}
