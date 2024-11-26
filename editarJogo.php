<?php
// Incluir a classe de jogos
require_once 'classes/jogos.class.php';

$jogo = new Jogos();

// Verificar se o ID foi passado para buscar o jogo a ser editado
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitizar o ID
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $jogoInfo = $jogo->buscar($id);

    // Verificar se o jogo existe
    if (empty($jogoInfo)) {
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
    <!-- Campo oculto para o ID do jogo -->
    <input type="hidden" name="id" value="<?= htmlspecialchars($jogoInfo['id'], ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Nome do Jogo -->
    <label for="nome">Nome do Jogo:</label>
    <input type="text" id="nome" name="nome" 
           value="<?= htmlspecialchars($jogoInfo['nome'], ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <!-- Descrição -->
    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required><?= htmlspecialchars($jogoInfo['descricao'], ENT_QUOTES, 'UTF-8'); ?></textarea><br>

    <!-- Data de Lançamento -->
    <label for="data_lancamento">Data de Lançamento:</label>
    <input type="date" id="data_lancamento" name="data_lancamento" 
           value="<?= htmlspecialchars($jogoInfo['data_lancamento'], ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <!-- Imagem -->
    <label for="imagem">Imagem:</label>
    <input type="file" id="imagem" name="imagem" accept="image/*"><br>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
