<?php
require_once 'classes/usuarios.class.php';

$usuarios = new Usuarios();

// Verifica se o ID do usuário foi passado na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    // Carrega os dados do usuário para edição
    $usuario = $usuarios->getUsuario($id);
} else {
    // Se não encontrar o usuário, redireciona de volta
    header('Location: listarUsuarios.php');  // Ou qualquer página onde você liste os usuários
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
</head>
<body>
    <h1>Editar Usuário</h1>
    <form action="editarUsuarioSubmit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>" />
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha"><br>

        <label for="permissoes">Permissões:</label>
        <input type="text" id="permissoes" name="permissoes" value="<?php echo implode(', ', explode(',', $usuario['permissoes'])); ?>"><br>

        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
