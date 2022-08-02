<?php

namespace App\Http\Controllers;

use App\Models\Room as ModelsRoom;
use Illuminate\Http\Request;

class Room extends Controller
{   
    /**
     * Armazena no banco de dados uma sala
     *
     * @param Request $req
     * @return void
     */
    public function store(Request $req)
    {   
        //valida o preenchimento dos campos
        $data = $req->validate([
            'name'=> ['required'],
        ]);

        //remove do array o _token para inserção dos dados
        $data = $req->except('_token');

        try {

            //insere um novo registro de sala no banco
            ModelsRoom::create($data);

            //retorna para a página de adm
            return redirect('/admin');

            //captura exceção de PDO
        } catch(\PDOException) {

            //retorna para a tela aneterior com erros
            return back()->withErrors(['Preencha todos os campos']);
        }  
    }

    /**
     * Busca no banco a sala cadastrada com o id passado pelo parâmetro e deleta o registro.
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        //busca um registro de filme com o id passado no parâmetro
        $room = ModelsRoom::find($id);

        try {

            //deleta o regiustro
            $room->delete();

            //retorna para a tela de adm
            return redirect('/admin');
        
            //captura exceções de PDO, caso tiver um filme vinculado a uma sessão, 
            //o onDELETE: Restrict retornará o erro
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {

                //retorna para a tela anterior com erros
                return back()->withErrors(['Sala vinculada à uma sessão']);
            }
        }
    }
}
