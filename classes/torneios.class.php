<?php
require 'conexao.class.php';

class Torneios {
    private $id;
    private $nome;
    private $id_jogos;
    private $descricao;
    private $data_inicio;
    private $data_fim;
    private $imagem;
    private $con;

    // Construtor da classe: Cria a conexão com o banco de dados
    public function __construct() {
        $this->con = new Conexao(); // Estabelece a conexão com o banco
    }

    // Método privado que verifica se um torneio com o mesmo nome já existe no banco de dados
    private function existeTorneio($nome) {
        $sql = $this->con->conectar()->prepare("SELECT id FROM torneios WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        // Retorna true se o torneio já existir (rowCount > 0), caso contrário, false
        return $sql->rowCount() > 0;
    }

    // Método para adicionar um novo torneio no banco de dados
    public function adicionar($nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem = null) {
        // Verifica se o torneio com o nome fornecido já existe
        if (!$this->existeTorneio($nome)) {
            try {
                // Armazena as informações fornecidas na classe
                $this->nome = $nome;
                $this->id_jogos = $id_jogos;
                $this->descricao = $descricao;
                $this->data_inicio = $data_inicio;
                $this->data_fim = $data_fim;
                $this->imagem = $imagem; // Imagem opcional

                // Prepara a consulta para inserir os dados do torneio no banco
                $sql = $this->con->conectar()->prepare("
                    INSERT INTO torneios (nome, id_jogos, descricao, data_inicio, data_fim, imagem) 
                    VALUES (:nome, :id_jogo, :descricao, :data_inicio, :data_fim, :imagem)
                ");
                // Vincula os valores dos parâmetros
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":id_jogo", $this->id_jogos, PDO::PARAM_INT);
                $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
                $sql->bindParam(":data_inicio", $this->data_inicio, PDO::PARAM_STR);
                $sql->bindParam(":data_fim", $this->data_fim, PDO::PARAM_STR);
                $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);  // Imagem opcional

                $sql->execute(); // Executa a consulta no banco
                return true;  // Retorna true se o torneio for adicionado com sucesso
            } catch (PDOException $ex) {
                // Caso ocorra erro ao adicionar o torneio, exibe a mensagem de erro
                echo "Erro ao adicionar torneio: " . $ex->getMessage();
                return false;  // Retorna false em caso de erro
            }
        } else {
            return false; // Torneio já existe no banco
        }
    }

    // Método para listar todos os torneios do banco de dados
    public function listar() {
        try {
            // Prepara e executa a consulta para selecionar todos os torneios
            $sql = $this->con->conectar()->prepare("SELECT * FROM torneios");
            $sql->execute();
            return $sql->fetchAll(); // Retorna todos os registros encontrados
        } catch(PDOException $ex) {
            // Caso ocorra erro na consulta, exibe a mensagem de erro
            echo "ERRO: ".$ex->getMessage();
        }
    }

    // Método para buscar um torneio pelo ID
    public function buscar($id) {
        try {
            // Prepara a consulta para buscar o torneio com o ID fornecido
            $sql = $this->con->conectar()->prepare("SELECT * FROM torneios WHERE id = :id");
            $sql->bindValue(':id', $id);  // Vincula o ID ao parâmetro da consulta
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch(); // Retorna os dados do torneio se encontrado
            } else {
                return array(); // Retorna um array vazio se o torneio não for encontrado
            }
        } catch(PDOException $ex) {
            // Exibe mensagem de erro caso ocorra um problema na consulta
            echo 'ERRO: '.$ex->getMessage();
        }
    }

    // Método para editar um torneio existente no banco de dados
    public function editar($id, $nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem = null) {
        try {
            // Verifica se o id_jogos existe no banco antes de atualizar o torneio
            $sql = $this->con->conectar()->prepare("SELECT id FROM jogos WHERE id = :id_jogos");
            $sql->bindValue(":id_jogos", $id_jogos);
            $sql->execute();

            if ($sql->rowCount() == 0) {
                // Caso o jogo não exista, exibe uma mensagem de erro
                echo "Erro: O jogo com o ID $id_jogos não foi encontrado na tabela 'jogos'.";
                return false;
            }

            // Atualiza os dados do torneio no banco
            $sql = $this->con->conectar()->prepare("UPDATE torneios SET nome = :nome, id_jogos = :id_jogos, descricao = :descricao, data_inicio = :data_inicio, data_fim = :data_fim, imagem = :imagem WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id_jogos", $id_jogos);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":data_inicio", $data_inicio);
            $sql->bindValue(":data_fim", $data_fim);
            $sql->bindValue(":imagem", $imagem ? $imagem['name'] : null); // Verifica se a imagem foi fornecida
            $sql->bindValue(":id", $id); // Vincula o ID do torneio

            // Executa a consulta de atualização
            if ($sql->execute()) {
                // Se houver uma imagem nova, processa e move a imagem para o diretório
                if ($imagem && isset($imagem['tmp_name']) && $imagem['tmp_name']) {
                    $tipo = $imagem['type'];
                    if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                        // Gera um nome único para a imagem e move para o diretório adequado
                        $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                        move_uploaded_file($imagem['tmp_name'], 'img/torneios/' . $tmpname);
    
                        // Atualiza a imagem no banco de dados
                        $sql = $this->con->conectar()->prepare("UPDATE torneios SET imagem = :imagem WHERE id = :id");
                        $sql->bindValue(":imagem", $tmpname);  // Atualiza com o novo nome da imagem
                        $sql->bindValue(":id", $id);
                        $sql->execute();
                    }
                }
    
                return true;  // Retorna true se a atualização for bem-sucedida
            } else {
                // Exibe erro se a consulta não for executada corretamente
                echo "Erro na execução da query de atualização!";
                return false; // Retorna false se ocorrer erro
            }

        } catch (PDOException $ex) {
            // Exibe erro caso ocorra algum problema durante a atualização
            echo 'Erro ao atualizar: ' . $ex->getMessage();
            return false;  // Retorna false em caso de erro
        }
    }

    // Método para deletar um torneio pelo ID
    public function deletar($id) {
        // Prepara e executa a consulta para deletar o torneio com o ID fornecido
        $sql = $this->con->conectar()->prepare("DELETE FROM torneios WHERE id = :id");
        $sql->bindValue(":id", $id);  // Vincula o ID ao parâmetro
        $sql->execute();
    }
}
?>
