<?php
// Incluir a classe Times para manipulação de dados de times
require_once 'classes/times.class.php';

// Verificar se o parâmetro 'id' foi passado via GET para buscar o time a ser editado
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Captura o ID do time

    // Cria um objeto da classe Times para buscar as informações do time
    $times = new Times();
    $time = $times->buscar($id); // Chama o método 'buscar' da classe Times, passando o ID

    // Verificar se o time foi encontrado no banco de dados
    if (!$time) {
        // Caso o time não exista, exibe uma mensagem de erro e encerra a execução do script
        echo "Time não encontrado!";
        exit;
    }
} else {
    // Caso o ID não tenha sido fornecido, exibe uma mensagem de erro e encerra a execução
    echo "ID do time não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Time</title> <!-- Título da página -->
</head>
<body>
    <h1>Editar Time</h1> <!-- Cabeçalho da página -->

    <!-- Formulário para edição dos dados do time -->
    <form action="editarTimeSubmit.php" method="POST" enctype="multipart/form-data">
        <!-- Campo oculto para passar o ID do time no formulário -->
        <input type="hidden" name="id" value="<?php echo $time['id']; ?>">

        <!-- Campo para edição do nome do time -->
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $time['nome']; ?>" required><br>

        <!-- Campo para edição do país do time -->
        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais" value="<?php echo $time['pais']; ?>" required><br>

        <!-- Campo para edição da descrição do time -->
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required><?php echo $time['descricao']; ?></textarea><br>

        <!-- Campo para upload de imagem do time (aceita múltiplas imagens) -->
        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem[]" id="imagem" multiple><br>

        <!-- Botão para submeter o formulário -->
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
