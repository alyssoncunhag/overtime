<?php
require 'conexao.class.php';

class Categorias {
    private $id;
    private $nome;
    private $descricao;
    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }

    // Verifica se a categoria já existe
    private function existeCategoria($nome) {
        // Limpa espaços extras e converte para minúsculas para garantir que a comparação seja correta
        $nome = trim(strtolower($nome));
        
        $sql = $this->con->conectar()->prepare("SELECT id FROM categorias WHERE LOWER(nome) = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();
        
        return $sql->rowCount() > 0; // Retorna TRUE se a categoria já existir
    }

    public function adicionar($nome, $descricao) {
        // Verifica se a categoria já existe
        if ($this->existeCategoria($nome)) {
            return "Categoria já cadastrada!";
        } else {
            try {
                $this->nome = $nome;
                $this->descricao = $descricao;

                // Insere a nova categoria no banco
                $sql = $this->con->conectar()->prepare("INSERT INTO categorias(nome, descricao) VALUES (:nome, :descricao)");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
                $sql->execute();

                return TRUE; // Categoria adicionada com sucesso
            } catch(PDOException $ex) {
                return "ERRO: " . $ex->getMessage(); // Retorna o erro em caso de falha
            }
        }
    }

    public function listar() {
        try {
            $sql = $this->con->conectar()->prepare('SELECT * FROM categorias');
            $sql->execute();
            return $sql->fetchAll();
        } catch(PDOException $ex) {
            echo "ERRO: " . $ex->getMessage();
        }
    }

    public function buscar($id) {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM categorias WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch();
            } else {
                return array();
            }
        } catch(PDOException $ex) {
            echo 'ERRO: '.$ex->getMessage();
        }
    }

    public function editar($nome, $descricao, $id) {
        if ($this->existeCategoria($nome)) {
            return "Categoria já cadastrada!";
        } else {
            try {
                $sql = $this->con->conectar()->prepare("UPDATE categorias SET nome = :nome, descricao = :descricao WHERE id = :id");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":descricao", $descricao);
                $sql->bindValue(":id", $id);
                $sql->execute();
                return TRUE;
            } catch(PDOException $ex) {
                echo 'ERRO: ' . $ex->getMessage();
            }
        }
    }

    public function deletar($id) {
        try {
            $sql = $this->con->conectar()->prepare("DELETE FROM categorias WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        } catch(PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();
        }
    }
}
?>
