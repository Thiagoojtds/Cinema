<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Authentication extends Controller
{   
    /**
     * Valida os campos recebidos pelo request e loga o usuário administrador
     *
     * @param Request $req
     * @return void
     */
    public function logIn(Request $req)
    {   
        //valida os campos
       $data = $req->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
       ]);

       //verifica se os campos estao vazios, caso sim retorna erro
       if ($data['password'] == '' || $data['email'] == '') {

            //retorna para a tela anterior com erros
            return back()->withErrors(['Preencha todos os campos']);
       }
       
       //cria um hash do password para ser buscado no banco e valida se está correto
       if (Auth::attempt($data)) {

            //gera um novo identificador de sessão
            $req->session()->regenerate();

            //redireciona para a tela de admin
            return redirect()->intended('/admin');
       }

       //caso não aconteça o login, retorna para a tela anterior com os erros
       return back()->withErrors(['E-mail ou senha inválido']);
    }

    /**
     * Desloga o usuário
     *
     * @param Request $req
     * @return void
     */
    public function logout(Request $req)
    {   
        //desloga
        Auth::logout();

        //invalida o identificador da sessão atual
        $req->session()->invalidate();

        //regenera CSRF token da sessão
        $req->session()->regenerateToken();

        //redireciona para a tela inicial
        return redirect('/');
    }
}
