<?php
// Incluir a classe de jogos
require 'classes/jogos.class.php';

$jogo = new Jogos();

// Verificar se o ID foi passado para buscar o jogo a ser editado
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $jogoInfo = $jogo->buscar($id);
    if(empty($jogoInfo)) {
        echo "Jogo não encontrado.";
        exit;
    }
} else {
    echo "ID do jogo não informado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogo</title>
</head>
<body>
    <h2>Editar Jogo</h2>
    <form action="editarJogoSubmit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $jogoInfo['id']; ?>">

        <label for="nome">Nome do Jogo:</label>
        <input type="text" id="nome" name="nome" value="<?= $jogoInfo['nome']; ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?= $jogoInfo['descricao']; ?></textarea><br>

        <label for="data_lancamento">Data de Lançamento:</label>
        <input type="date" id="data_lancamento" name="data_lancamento" value="<?= $jogoInfo['data_lancamento']; ?>" required><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem[]" multiple><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
