<?php
session_start();
include 'classes/times.class.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$time = new Times();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Times - OVERTIME</title>
    <link rel="stylesheet" href="css/gestaoTime.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>Gestão de Times</h1>
    </header>
    
    <div class="button-container">
        <a href="adicionarTime.php" class="button">ADICIONAR</a>
    </div>

    <hr>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>País</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $time->listar();
                foreach($lista as $item):
                ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['pais']; ?></td>
                        <td><?php echo $item['descricao']; ?></td>
                        <td><img src="<?php echo $item['imagem']; ?>" alt="Imagem do time" class="team-image"></td>
                        <td>
                            <a href="editarTime.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <a href="excluirTime.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
