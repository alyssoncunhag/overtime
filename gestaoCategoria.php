<?php
session_start();
include 'classes/categorias.class.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$categoria = new Categorias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Categorias - OVERTIME</title>
    <link rel="stylesheet" href="css/gestaoCategoria.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>Gestão de Categorias</h1>
    </header>
    
    <div class="button-container">
        <a href="adicionarCategoria.php" class="button">ADICIONAR</a>
    </div>

    <hr>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $categoria->listar();
                foreach($lista as $item):
                ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['descricao']; ?></td>
                        <td>
                            <a href="editarCategoria.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <a href="excluirCategoria.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
