<?php

namespace App\Http\Controllers;

use App\Models\Movie as ModelsMovie;
use Illuminate\Http\Request;

class Movie extends Controller
{
    /**
     * Valida os campos preenchidos e guarda um filme no banco de dados se estiver tudo certo.
     *
     * @param Request $req
     * @return void
     */
    public function store(Request $req)
    {
        //valida o preenchimento dos campos
        $data = $req->validate([
            'name'=> ['required'],
            'description' => ['required'],
            'duration'=> ['required'],
            'tags'=> ['required'],
            'image'=> ['required'],
            'classification'=> ['required'],
           ]);

        //remove o _token do array a ser passado para inserir no banco
        $data = $req->except('_token');

        try {
            //insere um novo filme no banco
            ModelsMovie::create($data);

            //retorna para a página principal
            return redirect('/');
        
        //pega exceções de PDO
        } catch (\PDOException) {

            //retorna erros para a página anterior
            return back()->withErrors(['Preencha todos os campos']);
        }
    }

    /**
     * Deleta do banco de dados um filme com o id passado pelo parâmetro
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {   
        //busca o filme com o id passado pelo parâmetro
        $movie = ModelsMovie::find($id);
        
        try {

            //deleta o filme encontrado
            $movie->delete();

            //redireciona para a página de adm
            return redirect('/admin');
            
            //epag exceção de PDO
        } catch (\PDOException $e) {
            
            //se tiver um filme vinculado a uma sessão, o onDELETE: Restrict retornará o erro
            if ($e->getCode() == 23000) {

                //redireciona para a tela anterior com os erros
                return back()->withErrors(['Filme vinculado à uma sessão']);
            }
        }
    }

    /**
     * Busca no banco o filme com o id passado e atualiza os campos.
     *
     * @param integer $id
     * @param Request $req
     * @return void
     */
    public function update(int $id, Request $req)
    {

        $movie = $req->validate([
            'name'=> ['required'],
            'description' => ['required'],
            'duration'=> ['required'],
            'tags'=> ['required'],
            'image'=> ['required'],
            'classification'=> ['required'],
           ]);
           
        $movie = ModelsMovie::find($id);

        try {

            $movie->update([
                'name' => $req->name,
                'duration' => $req->duration,
                'description' => $req->description,
                'tags' => $req->tags,
                'image'=> $req->image,
                'classification' => $req->classification
            ]) ;

            return redirect('/admin');
            
        } catch(\PDOException) {
            return back()->withErrors(['Preencha todos os campos.']);
        }
    }


            /**
     * Busca o filme a ser atualizado e retorna a view para atualização.
     *
     * @param integer $id
     * @return void
     */
    public function updateMoviePage(int $id)
    {   
        //busca o filme com o id recebido por parâmetro
        $movie = ModelsMovie::find($id);

        //retorna para a view de descrição com o filme encontrado
        return view('auth.updateMovie', [
            'movie' => $movie
        ]);
    }
}
