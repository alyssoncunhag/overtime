<?php
session_start();
include 'classes/torneios.class.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$torneio = new Torneios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Torneios - OVERTIME</title>
    <link rel="stylesheet" href="css/gestaoTorneio.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>Gestão de Torneios</h1>
    </header>
    
    <!-- Botão para adicionar torneio -->
    <div class="button-container">
        <a href="adicionarTorneio.php" class="button">ADICIONAR</a>
    </div>

    <hr>

    <!-- Tabela de torneios -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>ID Jogo</th>
                    <th>Descrição</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $torneio->listar();
                foreach($lista as $item):
                ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['id_jogo']; ?></td>
                        <td><?php echo $item['descricao']; ?></td>
                        <td><?php echo $item['data_inicio']; ?></td>
                        <td><?php echo $item['data_fim']; ?></td>
                        <td>
                            <a href="editarTorneio.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <a href="excluirTorneio.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
