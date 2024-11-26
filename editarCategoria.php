<?php
// Inclui o arquivo da classe 'Categorias', onde os métodos relacionados ao gerenciamento de categorias estão implementados
include 'classes/categorias.class.php';

// Instancia um objeto da classe 'Categorias' para interagir com as categorias no banco de dados
$categoria = new Categorias();

// Verifica se a URL contém um parâmetro 'id' e se ele não está vazio
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];  // Recupera o ID da categoria da URL
    // Chama o método 'getCategoria' da classe 'Categorias' para obter as informações da categoria com o ID fornecido
    $info = $categoria->getCategoria($id);

    // Se não encontrar a categoria no banco de dados (informações vazias), redireciona para a página inicial
    if (empty($info)) {
        header("Location: index.php");
        exit();  // Interrompe a execução do script
    }
}

// Verifica se os campos 'nome' e 'descricao' foram preenchidos no formulário
if (isset($_POST['nome']) && isset($_POST['descricao'])) {
    $nome = $_POST['nome'];           // Recupera o nome da categoria do formulário
    $descricao = $_POST['descricao']; // Recupera a descrição da categoria do formulário

    // Se o ID da categoria foi definido (indicando que é uma edição), chama o método 'editar'
    if (isset($id) && !empty($id)) {
        // Tenta editar a categoria com o ID especificado
        $resultado = $categoria->editar($id, $nome, $descricao);
    } else {
        // Se não existe um ID (indicando que é uma nova categoria), chama o método 'adicionar'
        $resultado = $categoria->adicionar($nome, $descricao);
    }

    // Se o resultado for TRUE, redireciona para a página inicial
    if ($resultado === TRUE) {
        header('Location: index.php');
        exit();  // Interrompe a execução do script após o redirecionamento
    } else {
        // Se houver erro, exibe uma mensagem de erro com o resultado retornado
        echo '<script type="text/javascript">alert("' . $resultado . '");</script>';
    }
}
?>

<!-- HTML que contém o formulário de adicionar ou editar categoria -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar/Editar Categoria</title>
    <!-- Link para o Bootstrap para estilizar o formulário -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Título da página, que muda dependendo se é uma edição ou adição de categoria -->
<h1><?php echo isset($id) && !empty($id) ? 'Editar Categoria' : 'Adicionar Categoria'; ?></h1>

<!-- Formulário de adição ou edição de categoria -->
<form method="POST">
    <?php if (isset($id) && !empty($id)): ?>
        <!-- Se for uma edição (tem ID), cria um campo oculto com o ID da categoria para ser enviado no formulário -->
        <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    <?php endif; ?>
    
    <!-- Campo para o nome da categoria -->
    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" value="<?php echo isset($info['nome']) ? $info['nome'] : ''; ?>" required><br><br>

    <!-- Campo para a descrição da categoria -->
    <label for="descricao">Descrição:</label><br>
    <input type="text" name="descricao" value="<?php echo isset($info['descricao']) ? $info['descricao'] : ''; ?>" required><br><br>

    <!-- Botão para enviar o formulário, que muda o texto dependendo se é para adicionar ou salvar -->
    <button type="submit"><?php echo isset($id) && !empty($id) ? 'Salvar Alterações' : 'Adicionar Categoria'; ?></button>
</form>

<!-- Link para o script do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
