<?php
require_once 'conexao.class.php';

class Usuarios {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $permissoes;
    private $con;

    public function __construct() {
        $this->con = new Conexao();
        $this->permissoes = []; // Garantir que permissoes seja sempre um array
    }

    public function existeEmail($email){
        $sql = $this->con->conectar()->prepare("SELECT id FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }
        return false;
    }

    public function adicionar($nome, $email, $senha, $permissoes){
        // Verificar se permissões é uma string e se for, converte para array
        if (is_string($permissoes)) {
            $permissoes = explode(',', $permissoes); // Convertendo string de permissões para array
        }
    
        // Verifica se o e-mail já existe
        $emailExistente = $this->existeEmail($email);
        if($emailExistente === false){  // Se o email não existir
            try{
                // Criptografando a senha antes de salvar no banco de dados
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    
                $this->nome = $nome;
                $this->email = $email;
                $this->senha = $senhaCriptografada; // Armazenando a senha criptografada
                $this->permissoes = $permissoes;  // Garantir que seja um array
    
                // Agora convertendo o array de permissões para string antes de salvar no banco
                $sql = $this->con->conectar()->prepare("INSERT INTO usuarios (nome, email, senha, permissoes) VALUES (:nome, :email, :senha, :permissoes)");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":email", $email);
                $sql->bindValue(":senha", $senhaCriptografada); // Salvando a senha criptografada
                $sql->bindValue(":permissoes", implode(',', $permissoes));  // Convertendo array em string separada por vírgulas
                $sql->execute();
    
                return TRUE;
            }catch(PDOException $ex){
                return 'ERRO: '.$ex->getMessage();
            }
        }else{
            return FALSE;  // Email já existe
        }
    }
    
    
    

    public function fazerLogin($email, $senha){
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $usuario = $sql->fetch();
    
            // Verificar a senha utilizando password_verify
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['logado'] = $usuario['id'];
                $this->setUsuario($usuario['id']); // Carregar os dados do usuário, incluindo as permissões
                return TRUE;
            }
        }
        return FALSE;
    }
    
    

    public function setUsuario($id) {
        $this->id = $id;
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $dados = $sql->fetch();
            $this->nome = $dados['nome'];
            $this->email = $dados['email'];
            $this->permissoes = explode(',', $dados['permissoes']);  // Convertendo string de permissões de volta para array
        }
    }
    

    public function getPermissoes(){
        return $this->permissoes;
    }

    public function temPermissoes($permissoes){
        // Verifica se a permissão está no array
        if (in_array($permissoes, $this->permissoes)) {
            return true;
        }
        return false;
    }

    public function listar() {
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios");
            $sql->execute();
            return $sql->fetchAll();
        }catch(PDOException $ex){
            echo "ERRO: ".$ex->getMessage();
        }
    }

    public function buscar($id){
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                return $sql->fetch();
            }else{
                return array();
            }
        }catch(PDOException $ex){
            echo "ERRO: ".$ex->getMessage();
        }
    }

    public function editar($nome, $email, $senha, $permissoes, $id){
        $emailExistente = $this->existeEmail($email);
        if($emailExistente !== false && $emailExistente['id'] != $id){
            return FALSE;
        }else{
            try{
                $sql = $this->con->conectar()->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, permissoes = :permissoes WHERE id = :id");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':email', $email);
                $sql->bindValue(':senha', $senha);
                $sql->bindValue(':permissoes', implode(',', $permissoes));  // Convertendo array de permissões para string
                $sql->bindValue(':id', $id);
                $sql->execute();

                return TRUE;
            }catch(PDOException $ex){
                echo 'ERRO '.$ex->getMessage();
            }
        }
    }

    public function deletar($id){
        $sql = $this->con->conectar()->prepare("DELETE FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function getUsuario($id){
        $array = array();
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
        }
        return $array;
    }
}
