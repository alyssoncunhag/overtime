<?php
// Incluir a classe de jogos, que contém os métodos para interagir com os jogos no banco de dados
require_once 'classes/jogos.class.php';

// Cria um objeto da classe Jogos para interagir com o banco de dados
$jogo = new Jogos();

// Verificar se o ID foi passado via GET, indicando que estamos editando um jogo
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitizar o ID para garantir que seja um número válido
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Chama o método 'buscar' da classe Jogos para buscar as informações do jogo com o ID fornecido
    $jogoInfo = $jogo->buscar($id);

    // Verifica se o jogo foi encontrado no banco de dados
    if (empty($jogoInfo)) {
        // Se o jogo não for encontrado, exibe uma mensagem de erro e encerra o script
        echo "Jogo não encontrado.";
        exit;  // Encerra a execução do código
    }
} else {
    // Se o ID não for passado ou estiver vazio, exibe uma mensagem de erro
    echo "ID do jogo não informado.";
    exit;  // Encerra a execução do código
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define a codificação de caracteres como UTF-8 e a responsividade para dispositivos móveis -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogo</title> <!-- Título da página -->
    <!-- Linkando o CSS -->
    <link rel="stylesheet" href="css/editarJogo.css">
</head>
<body>
    <!-- Cabeçalho da página de edição -->
    <h2>Editar Jogo</h2>

    <!-- Container do formulário -->
    <div class="form-container">
        <!-- Formulário para editar as informações de um jogo -->
        <form action="editarJogoSubmit.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para o ID do jogo, que será enviado com o formulário -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($jogoInfo['id'], ENT_QUOTES, 'UTF-8'); ?>">

            <!-- Nome do jogo -->
            <div class="input-group">
                <label for="nome">Nome do Jogo:</label>
                <input type="text" id="nome" name="nome" 
                    value="<?= htmlspecialchars($jogoInfo['nome'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <!-- Descrição do jogo -->
            <div class="input-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required><?= htmlspecialchars($jogoInfo['descricao'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <!-- Data de lançamento -->
            <div class="input-group">
                <label for="data_lancamento">Data de Lançamento:</label>
                <input type="date" id="data_lancamento" name="data_lancamento" 
                    value="<?= htmlspecialchars($jogoInfo['data_lancamento'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <!-- Imagem do jogo -->
            <div class="input-group">
                <label for="imagem">Imagem:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
            </div>

            <!-- Botão de enviar -->
            <div class="button-container">
                <button class="submit-button" type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>
</html>
