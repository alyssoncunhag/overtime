<?php
include 'classes/categorias.class.php';
$categoria = new Categorias();

if (isset($_POST['nome']) && isset($_POST['descricao'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    
    // Chama o método adicionar e verifica se o retorno é um erro
    $resultado = $categoria->adicionar($nome, $descricao);
    
    if ($resultado === TRUE) {
        // Categoria adicionada com sucesso, redireciona para a página inicial
        header('Location: index.php');
        exit();
    } else {
        // Exibe mensagem de erro (categoria já cadastrada ou erro na execução)
        echo '<script type="text/javascript">alert("' . $resultado . '");</script>';
    }
}
?>
