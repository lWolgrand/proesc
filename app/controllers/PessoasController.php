<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class PessoasController extends BaseController {

    public function visualizarFormulario() {
        return View::make('formularios.cadastro');
    }

    public function cadastrarPessoa() {

        return Redirect::to('/cadastro')->with('success', 'Cadastro realizado com sucesso!');
    }
}