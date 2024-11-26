<?php
// Inclui a classe 'Usuarios', que contém os métodos necessários para manipular os dados de usuários
require_once 'classes/usuarios.class.php';

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os dados do formulário enviado
    $id = $_POST['id']; // ID do usuário, necessário para identificar qual usuário editar
    $nome = $_POST['nome']; // Nome do usuário
    $email = $_POST['email']; // Email do usuário
    $senha = $_POST['senha'];  // Senha do usuário, pode ser vazia (não será alterada se estiver vazia)
    $permissoes = $_POST['permissoes']; // Permissões do usuário, que são passadas no formulário

    // Cria uma instância da classe 'Usuarios' para manipulação dos dados
    $usuarios = new Usuarios();

    // Se a senha não for fornecida (campo de senha está vazio), mantemos a senha atual do usuário
    if (empty($senha)) {
        // Carrega os dados do usuário atual, especificamente a senha
        $usuarioAtual = $usuarios->getUsuario($id); // Método 'getUsuario' retorna os dados do usuário pelo ID
        $senha = $usuarioAtual['senha']; // Mantém a senha atual, pois o campo de senha foi deixado vazio
    }

    // Chama o método 'editar' da classe 'Usuarios' para atualizar os dados do usuário
    // Passa os dados do formulário, incluindo o ID para identificar o usuário a ser editado
    $resultado = $usuarios->editar($nome, $email, $senha, $permissoes, $id);

    // Verifica se a atualização foi bem-sucedida
    if ($resultado) {
        // Se a atualização foi bem-sucedida, redireciona o usuário para a página principal ou listagem de usuários
        header('Location: index.php');
        exit(); // Encerra a execução do script após o redirecionamento
    } else {
        // Se ocorrer um erro, exibe uma mensagem de erro
        echo 'Erro ao editar o usuário!'; // Mensagem simples de erro, pode ser melhorada com mais detalhes
    }
}
?>
