<?php

namespace App\Http\Controllers;

use App\Models\Movie as ModelsMovie;
use App\Models\Room as ModelsRoom;
use App\Models\Session as ModelsSession;
use DateTime;
use Exception;
use Illuminate\Http\Request;


class Session extends Controller
{   
    /**
     * Válida todas as regras de negócio para cadastro de uma sessão, e se tudo estiver 
     * correto armazena uma nova sessão no banco de dados.
     *
     * @param Request $req
     * @return void
     */
    public function store(Request $req)
    {
        //busca o filme com o nome recebido na requisição
        $movie = ModelsMovie::where('name', $req['movie_id'])->get();

        //separa em um array os dados a serem utilizados
        $movie = $movie->map(function($movie){
            return collect($movie->toArray())
            ->only(['name', 'id'])
            ->all();
        });

        //percorre o array e armazena o id
        foreach ($movie as $movie) {
            $movie_id = $movie['id'];
        }

        //busca as salas com o nome recebido na requisição
        $room = ModelsRoom::where('name', $req['room_id'])->get();

        //separa em array 
        $room = $room->map(function($room){
            return collect($room->toArray())
            ->only(['name', 'id'])
            ->all();
        });

        //armazena o id da sala
        foreach ($room as $room) {
            $room_id = $room['id'];
        }

        //cria uma nova data a partir da data passada para adicionar a sessão 
        $date = new DateTime($req->date);


        if ($this->sessionAlreadyExists($req)) {
            //retorna para a página anterior com erros
            return back()->withErrors(['Sessão já adicionada']);
        }
        else if ($this->roomInSession($req)) {
            //retorna para a página anterior com erros
            return back()->withErrors(['Sala estará em sessão']);
        }
        else if ($this->isCineClosed($req)) {
            //retorna para a página anterior com erros
            return back()->withErrors(['Cinema fechado nesse horário']);

        }
        else {

            try {

                //faz a inserção de uma nova sessão no banco
                ModelsSession::create([
                    'movie_id' => $movie_id,
                    'room_id'=> $room_id,
                    'date' => $date,
                    'time' => $req->time
                ]);
        
                //retorna para a página pricipal
                return redirect('/');

                //captura exceção de PDO
            } catch(\PDOException) {

                //retonra para a página anterior com erros
                return back()->withErrors(['Preencha todos os campos']);
            }
        }

    }

    /**
     * Busca o filme recebido por parâmetro $id e atualiza o registro de sessão no banco.
     *
     * @param integer $id
     * @param Request $req
     * @return void
     */
    public function update(int $id, Request $req)
    {   
        //busca a sessão com o id passado no parâmetro
        $session = ModelsSession::find($id);

        //busca o filme mcom o nome recebido na requisição
        $movies = ModelsMovie::where('name', '=', $req->movie_id)->get();

        //busca a sala com o parâmetro recebido na requisição
        $rooms = ModelsRoom::where('name', '=', $req->room_id)->get();

        //separa os dados da sala em um array
        $rooms = $rooms->map(function($room){ 								
            return collect($room->toArray())
                    ->only(['id', 'name'])
                    ->all();
            
        });

        //armazena o ID da sala
        foreach($rooms as $room){
            $roomID = $room['id'];
        }

        //separa os dados do filme em um array
        $movies = $movies->map(function($movie){ 								
            return collect($movie->toArray())
                    ->only(['id', 'name'])
                    ->all();
        }); 

        //armazena o id do filme
        foreach($movies as $movie){
            $movieID = $movie['id'];
        }

        if ($this->sessionAlreadyExists($req)) {
            //retorna para a página anterior com erros
            return back()->withErrors(['Sessão já adicionada']);
        }
        else if ($this->roomInSession($req)) {
            //retorna para a página anterior com erros
            return back()->withErrors(['Sala estará em sessão']);
        }
        else if ($this->isCineClosed($req)) {
            //retorna para a página anterior com erros
            return back()->withErrors(['Cinema fechado nesse horário']);

        }
        else {

            try{

                //atualiza a sessão
                $session->update([
                    'movie_id' => $movieID,
                    'room_id' => $roomID,
                    'date' => $req->date,
                    'time' => $req->time
                ]) ;

                //redireciona para a tela de adm
                return redirect('/admin');
            
            }catch(Exception){

                //retorna para a tela anterior com erros
                return back()->withErrors(['Preencha todos os campos.']);
            }
        }
    
    }

    /**
     * Busca a sessão recebida por parâmetro e deleta o registro.
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {   
        //busca o a sessão com o id recebido no parâmetro
        $session = ModelsSession::find($id);

        //apaga o registro da sessão
        $session->delete();
        
        //retorna para a tela de adm
        return redirect('/admin');
    }

    /**
     * Busca as sessões cadastradas e verifica se à sessão a ser adicionada já existe
     * @param Request $req
     * @return boolean
     */
    public function sessionAlreadyExists(Request $req)
    {
        //busca as sessões cadastradas com os filmes e sessões vinculados
        $sessions = ModelsSession::join('movies', 'movie_id', '=', 'movies.id')
                                ->join('rooms', 'room_id', '=', 'rooms.id')
                                ->select('sessions.date','sessions.time' ,'movies.name AS movieName', 'rooms.name AS roomName')
                                ->get();

        //coloca em um array com os dados para serem acessados
        $sessionToAdd = $req->all();
        
        //separa em array as sessões com os dados
        $sessions = $sessions->map(function($session){ 								
            return collect($session->toArray())
                    ->only(['movieName', 'date', 'time', 'roomName'])
                    ->all();
            
        });  

        foreach ($sessions as $session)
        {   
            //verifica se os dados a serem adicionados são iguais aos dados já existentes
            if ($sessionToAdd['movie_id'] == $session['movieName'] 
            && $sessionToAdd['room_id'] == $session['roomName']
            && $sessionToAdd['date'] == $session['date']
            && $sessionToAdd['time'] == $session['time']) {
               return true;
            }
        }
        return false;
    }

    /**
     * Busca todas as sessões no banco e verifica se a sala a ser adicionada a sessão 
     * no momento selecionado já possui uma sessão cadastrada.
     *
     * @param Request $req
     * @return boolean
     */
    public function roomInSession(Request $req)
    {
        //adiciona em um array os dados da requisição
        $sessionToAdd = $req->all();

        //busca as sessões com salas e filmes vinculados
        $session = ModelsSession::join('rooms', 'room_id', '=', 'rooms.id')
                                ->join('movies', 'movie_id', '=', 'movies.id')
                                ->select('date','time', 'rooms.name AS roomName', 'movies.name AS movieName','movies.duration AS movieDuration')
                                ->get();

        //separa em array os dados
        $sessions = $session->map(function($session){
            return collect($session->toArray())
                    ->only(['date', 'time', 'roomName', 'movieName', 'movieDuration'])
                    ->all();
        });
        
        //percorre o array de sessões
        foreach($sessions as $session){

            //verifica se a sala que está tentando adicionar possui o mesmo nome que uma 
            //sala já cadastrada
            if($session['roomName'] == $sessionToAdd['room_id']){
                
                //verifica se as respectivas datas e horários são iguais
                if($session['date'] == $sessionToAdd['date']
                    && $session['time'] == $sessionToAdd['time']) {
                    //Sala indisponível, mesmo dia e hora
                    return true;
                }

                //seára as horas minutos e segundos em uma lista
                list($hours,$minutes,$seconds) = explode(':', $session['movieDuration']);

                //transforma a duração do filme em segundos
                $movieDurationSeconds = $hours * 3600 + $minutes * 60 + $seconds;
                
                //cria um novo objeto de Datetime com o horário da sessão já cadastrada
                $sessionDateTime = new DateTime($session['date'] . $session['time']);

                //armazena em timestamp o dia e horário que o filme em sessão irá acabar
                $movieEnded = $sessionDateTime->getTimestamp() + $movieDurationSeconds;
                
                //transforma o objeto Datetime em uma string com a data
                $sessionDate = date('Y-m-d H:i:s', $sessionDateTime->getTimestamp());

                //armazena uma string com a data e hora que a sessão acaba
                $nextSessionTime = date('Y-m-d H:i:s', $movieEnded);

                //armazena uma string com a data e hora da sessão a ser adicionada
                $sessionToAddDatetime = date($sessionToAdd['date'] .' '.$sessionToAdd['time']);

                //veririca se a data e horário a ser adicionado já existe uma sessão
                if($sessionToAddDatetime > $sessionDate 
                    && $sessionToAddDatetime < $nextSessionTime) {
                    // Sala em sessão
                    return true;
                }

                //armazena um timestamp com a data da sessão - 3 horas antes
                //(tempo mínimo para adicionar uma nova sessão)
                $previousSessionTime = strtotime('-3 hours', $sessionDateTime->getTimestamp());

                //converte para uma string com a data e hora
                $previousSessionDate = date('Y-m-d H:i:s', $previousSessionTime);

                //Para adicionar uma sessão deve ser pelo menos 3 horas antes da 
                //próxima sessão
                if($sessionToAddDatetime > $previousSessionDate 
                    && $sessionToAddDatetime < $sessionDate){
                    
                    return true;
                }
                return false;
            }
        }
    }

    /**
     * Verifica se o cinema estará fechado na data e horário selecionado para adicionar 
     * a sessão.
     *
     * @param Request $req
     * @return boolean
     */
    public function isCineClosed(Request $req): bool
    {
     
        //armazena um objeto com o horário que o cinema abre, 10am no dia à ser adicionado
        $firstSessionTime = new Datetime($req['date'] .'10am');

        //armazena um objeto com o horário que o cinema fecha, 11pm no dia à ser adicionado
        $lastSessionTime = new DateTime($req['date'] . '11pm');

        //armazena um objeto com o horário à ser adicionado
        $session = new DateTime($req['date'] . $req['time']);

        //verifica se o horário à ser adicionado é antes das 10am
        if ($session < $firstSessionTime) {;
            return true;
            //verifica se o horário à ser adicionado é depois das 11pm
        } else if ($session > $lastSessionTime) {
            return true;
        } else 

        return false;
    }


        /**
     * Busca a sessão à ser atualizada e retorna a view para atualização.
     *
     * @param integer $id
     * @return void
     */
    public function updateSessionPage(int $id)
    {
        //pega todos as sessões, filmes e salas cadastradas
        $session = ModelsSession::find($id);
        $movies = ModelsMovie::get();
        $rooms = ModelsRoom::get();

        //retonra para a view de atualização de sessão, com os resultados encontrados
        return view('auth.updateSession', [
            'session' => $session,
            'movies' => $movies,
            'rooms' => $rooms
        ]);
    }
}
