<?php
include 'classes/usuarios.class.php';
$usuario = new Usuarios();

if (!empty($_POST['email'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $permissoes = $_POST['permissoes'];

    // Verifica se o email já está cadastrado
    if ($usuario->existeEmail($email)) {
        // Email já cadastrado, exibe mensagem de erro
        echo '<script type="text/javascript">
                alert("Este e-mail já está cadastrado. Por favor, use outro e-mail.");
                window.location.href = "adicionarUsuario.php"; // Volta para o formulário
              </script>';
    } else {
        // Adiciona o usuário no banco de dados
        if ($usuario->adicionar($nome, $email, $senha, $permissoes)) {
            header('Location: index.php'); // Redireciona para a página inicial após sucesso
            exit;
        } else {
            echo '<script type="text/javascript">
                    alert("Erro ao adicionar usuário. Tente novamente.");
                    window.location.href = "adicionarUsuario.php";
                  </script>';
        }
    }
}
?>
