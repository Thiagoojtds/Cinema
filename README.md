
<h1> Projeto de Cinema feito em Laravel</h1>

<br>
<p> Antes de executar o programa é necessário previamente instalado o gerenciador de depências composer e o compilador de PHP </p>
<p> Primeiramente faça o clone do repositório para sua máquina local com o comando </p>

```
git clone https://github.com/Thiagoojtds/Cinema
```

<p> Abra o terminal na pasta raiz do projeto e instale as depencências necessárias para utilização do programa com o comando</p>

```
composer install
```

<p> Depois copie o arquivo .env.example e crie um novo .env e gere a chave da aplicação executando os comandos</p>

```
cp .env.example .env
php artisan key:generate
```

<p> Crie um novo banco de dados e altere o arquivo .env gerado atualizando os seguintes campos</p>

```
DB_DATABASE={Nome do banco criado}
DB_USERNAME={Úsuário para conexão com o banco}
DB_PASSWORD={Senha para conexão com o banco}
```

<p> Crie as tabelas para a aplicação no banco criado com o comando</p>

```
php artisan migrate
```

<p> Para popular as tabelas do banco de dados criado com registros já predefinidos, utilize o comando

```
php arisan db:seed
```

<p>Inicie o servidor artisan do Laravel com o comando abaixo e já pode utilizar o sistema no endereço de localhost que será fornecido.</p>

```
php artisan serve
```

<p> O ucuário admin para acessar a tela administrativa é: </p>
<p> e-mail: admin@admin.com </p>
<p> senha: 1234 </p>



