<?php
// Inclui a classe 'Usuarios' para manipular as operações de usuário
require_once 'classes/usuarios.class.php';

// Cria uma instância da classe 'Usuarios'
$usuarios = new Usuarios();

// Verifica se o ID do usuário foi passado via URL (com o método GET)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Caso o ID esteja presente, armazena o valor do ID na variável $id
    $id = $_GET['id'];
    // Carrega os dados do usuário correspondente ao ID para edição
    $usuario = $usuarios->getUsuario($id);
} else {
    // Caso o ID não seja passado ou esteja vazio, redireciona o usuário para a lista de usuários
    // Isso pode ser feito em uma página que liste todos os usuários cadastrados
    header('Location: listarUsuarios.php');  // Ou qualquer página onde você liste os usuários
    exit();  // Interrompe a execução do script
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <!-- Vinculando o arquivo CSS -->
    <link rel="stylesheet" href="css/editarUsuario.css">
</head>
<body>
    <header>
        <h1>Editar Usuário</h1>
    </header>
    <div class="form-container">
        <form action="editarUsuarioSubmit.php" method="POST">
            <!-- Campo oculto para o ID do usuário, necessário para atualizar o registro correto -->
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>" />

            <!-- Grupo de input para o nome do usuário -->
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>
            </div>

            <!-- Grupo de input para o email do usuário -->
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            </div>

            <!-- Grupo de input para a senha do usuário -->
            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha">
            </div>

            <!-- Grupo de input para permissões do usuário -->
            <div class="input-group">
                <label for="permissoes">Permissões:</label>
                <input type="text" id="permissoes" name="permissoes" value="<?php echo implode(', ', explode(',', $usuario['permissoes'])); ?>">
            </div>

            <!-- Botão para enviar o formulário -->
            <div class="button-container">
                <input type="submit" value="Salvar Alterações" class="submit-button">
            </div>
        </form>
    </div>
</body>
</html>
