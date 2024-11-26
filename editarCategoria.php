<?php
include 'classes/categorias.class.php';
$categoria = new Categorias();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $info = $categoria->getCategoria($id);

    if (empty($info)) {
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST['nome']) && isset($_POST['descricao'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    if (isset($id) && !empty($id)) {
        $resultado = $categoria->editar($id, $nome, $descricao);
    } else {
        $resultado = $categoria->adicionar($nome, $descricao);
    }

    if ($resultado === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo '<script type="text/javascript">alert("' . $resultado . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar/Editar Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h1><?php echo isset($id) && !empty($id) ? 'Editar Categoria' : 'Adicionar Categoria'; ?></h1>

<form method="POST">
    <?php if (isset($id) && !empty($id)): ?>
        <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    <?php endif; ?>
    
    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" value="<?php echo isset($info['nome']) ? $info['nome'] : ''; ?>" required><br><br>

    <label for="descricao">Descrição:</label><br>
    <input type="text" name="descricao" value="<?php echo isset($info['descricao']) ? $info['descricao'] : ''; ?>" required><br><br>

    <button type="submit"><?php echo isset($id) && !empty($id) ? 'Salvar Alterações' : 'Adicionar Categoria'; ?></button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
