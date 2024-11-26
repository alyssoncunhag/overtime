<?php
include 'classes/categorias.class.php'; // Corrigido o ponto e vírgula no final
$categoria = new Categorias(); // Objeto da classe Categorias

// Verifica se o formulário foi enviado
if (isset($_POST['nome']) && isset($_POST['descricao'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    if (isset($id) && !empty($id)) {
        // Se o ID estiver presente, chama o método de edição
        $resultado = $categoria->editar($id, $nome, $descricao);
    } else {
        // Se o ID não estiver presente, chama o método de adicionar
        $resultado = $categoria->adicionar($nome, $descricao);
    }

    if ($resultado === TRUE) {
        // Categoria adicionada ou editada com sucesso
        header('Location: index.php');
        exit();
    } else {
        // Exibe mensagem de erro
        echo '<script type="text/javascript">alert("' . $resultado . '");</script>';
    }
}
?>
