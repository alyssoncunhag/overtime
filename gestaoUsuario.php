<?php
session_start();
include 'classes/usuarios.class.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$usuario = new Usuarios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários - OVERTIME</title>
    <link rel="stylesheet" href="css/gestaoUsuario.css"> <!-- Linkando o CSS -->
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <h1>Gestão de Usuários</h1>
    </header>
    
    <!-- Botão para adicionar usuário -->
    <div class="button-container">
        <a href="adicionarUsuario.php" class="button">ADICIONAR</a>
    </div>

    <hr>

    <!-- Tabela de usuários -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Permissões</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $usuario->listar();
                foreach($lista as $item):
                ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['email']; ?></td>
                        <td><?php echo $item['senha']; ?></td>
                        <td><?php echo $item['permissoes']; ?></td>
                        <td>
                            <a href="editarUsuario.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <a href="excluirUsuario.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
