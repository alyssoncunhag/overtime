<?php
require 'conexao.class.php';

class Times{
    private $id;
    private $nome;
    private $pais;
    private $descricao;
    private $imagem;

    private $con;

    public function __construct(){
        $this->con = new Conexao();
    }

    private function existeTime($nome){
        $sql = $this->con->conectar()->prepare("SELECT id FROM times WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        if( $sql->rowCount() > 0){
            $array = $sql->fetch();
    }else{
        $array = array();
    }
    return $array;
}

public function adicionar($nome, $pais, $descricao, $imagem){
    // Verificando se o time já existe
    $existeTime = $this->existeTime($nome);
    if (count($existeTime) == 0) {
        try {
            $this->nome = $nome;
            $this->pais = $pais;
            $this->descricao = $descricao;
            $this->imagem = $imagem;  // Armazenando o nome do arquivo de imagem

            // Inserindo o time no banco de dados
            $sql = $this->con->conectar()->prepare("INSERT INTO times(nome, pais, descricao, imagem) VALUES (:nome, :pais, :descricao, :imagem)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":pais", $this->pais, PDO::PARAM_STR);
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);  // Salvando o nome da imagem
            $sql->execute();

            return TRUE;
        } catch(PDOException $ex) {
            return "ERRO: ".$ex->getMessage();
        }
    }
    return FALSE;
}


public function listar(){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM times");
        $sql->execute();
        return $sql->fetchAll();
    }catch(PDOException $ex){
        echo "ERRO: ".$ex->getMessage();
    }
}

public function buscar($id){
    try{
        // Corrigido: A variável :id deve ser vinculada corretamente
        $sql = $this->con->conectar()->prepare("SELECT * FROM times WHERE id = :id");
        $sql->bindValue(':id', $id);  // Vincula o parâmetro :id corretamente
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetch();  // Retorna os dados do time
        } else {
            return array();  // Retorna um array vazio caso não encontre
        }
    } catch(PDOException $ex) {
        echo 'ERRO: ' . $ex->getMessage();  // Exibe erro caso aconteça
    }
}


// No método editar(), corrigi a forma como $imagem é tratada:
    public function editar($nome, $pais, $descricao, $imagem, $id){
        $timeExistente = $this->existeTime($nome);
        if(count($timeExistente) > 0 && $timeExistente['id'] != $id){
            return FALSE;
        }else{
            try{
                // Atualizando os dados do time no banco
                $sql = $this->con->conectar()->prepare("UPDATE times SET nome = :nome, pais = :pais, descricao = :descricao WHERE id = :id");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":pais", $pais);
                $sql->bindValue(":descricao", $descricao);
                $sql->bindValue(":id", $id);
                $sql->execute();
    
                // Se houver imagem, somente atualizar o campo no banco de dados
                if (!empty($imagem)) {
                    $sql = $this->con->conectar()->prepare("UPDATE times SET imagem = :imagem WHERE id = :id");
                    $sql->bindValue(":imagem", $imagem);  // Aqui estamos apenas salvando o nome da imagem
                    $sql->bindValue(":id", $id);
                    $sql->execute();
                }
    
                return TRUE;
            } catch(PDOException $ex){
                echo 'ERRO: '.$ex->getMessage();
            }
        }
    }
    
    

public function deletar($id){
    $sql = $this->con->conectar()->prepare("DELETE FROM times WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
}
}