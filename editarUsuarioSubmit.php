<?php
require_once 'classes/usuarios.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];  // Senha pode ser vazia
    $permissoes = $_POST['permissoes'];

    // Cria o objeto e chama o método para editar
    $usuarios = new Usuarios();
    
    // Se a senha não for fornecida, mantemos a senha atual
    if (empty($senha)) {
        // Carregar a senha atual do usuário
        $usuarioAtual = $usuarios->getUsuario($id);
        $senha = $usuarioAtual['senha'];
    }

    // Atualiza o usuário
    $resultado = $usuarios->editar($nome, $email, $senha, $permissoes, $id);

    if ($resultado) {
        // Redireciona de volta para a listagem de usuários ou página de sucesso
        header('Location: index.php');
        exit();
    } else {
        // Se falhar, pode mostrar uma mensagem de erro
        echo 'Erro ao editar o usuário!';
    }
}
?>
