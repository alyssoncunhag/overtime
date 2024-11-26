<?php
require_once 'classes/times.class.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $times = new Times();
    $time = $times->buscar($id);
    
    if (!$time) {
        echo "Time não encontrado!";
        exit;
    }
} else {
    echo "ID do time não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Time</title>
</head>
<body>
    <h1>Editar Time</h1>

    <form action="editarTimeSubmit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $time['id']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $time['nome']; ?>" required><br>

        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais" value="<?php echo $time['pais']; ?>" required><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required><?php echo $time['descricao']; ?></textarea><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem[]" id="imagem" multiple><br>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
