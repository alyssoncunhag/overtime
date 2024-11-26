<?php
// Fábrica de conexões (connection factory) - responsável por criar a conexão com o banco
class Conexao {
    private $usuario;  // Vai armazenar o nome do usuário do banco
    private $senha;    // Vai armazenar a senha do banco
    private $banco;    // Nome do banco de dados
    private $servidor; // Endereço do servidor (aqui está como localhost)

    private static $pdo; // Aqui a gente guarda a instância do PDO (pra não ficar criando um novo sempre)

    // Construtor da classe, basicamente define os dados de conexão
    public function __construct(){
        $this->servidor = "localhost"; // Servidor padrão (localhost)
        $this->banco = "overtime"; // Nome do banco de dados
        $this->usuario = "root"; // Usuário do banco
        $this->senha = ""; // Senha do banco (aqui tá vazia pq é default no XAMPP e tal)
    }

    // Função que retorna a conexão com o banco (se ainda não tiver uma instância de PDO, cria uma)
    public function conectar(){
        try{
            // Se ainda não tiver uma instância de PDO criada, cria uma
            if(is_null(self::$pdo)){
                // Aqui é onde cria a conexão usando as credenciais configuradas acima
                self::$pdo = new PDO("mysql:host=".$this->servidor.";dbname=".$this->banco, $this->usuario, $this->senha);
            }
            // Retorna a instância da conexão (PDO)
            return self::$pdo;
        }catch(PDOException $ex){
            echo $ex->getMessage(); // Se der erro, ele vai mostrar a mensagem do erro
        }
    }
}
?>
