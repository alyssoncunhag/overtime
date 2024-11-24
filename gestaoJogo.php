<?php
session_start();
include 'classes/jogos.class.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$jogo = new Jogos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Jogos - OVERTIME</title>
    <link rel="stylesheet" href="css/gestaoJogo.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>Gestão de Jogos</h1>
    </header>
    
    <div class="button-container">
        <a href="adicionarJogo.php" class="button">ADICIONAR</a>
    </div>

    <hr>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data de Lançamento</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $jogo->listar();
                foreach($lista as $item):
                ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['descricao']; ?></td>
                        <td><?php echo $item['data_lancamento']; ?></td>
                        <td><img src="<?php echo $item['imagem']; ?>" alt="Imagem do jogo" class="game-image"></td>
                        <td>
                            <a href="editarJogo.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <a href="excluirJogo.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
