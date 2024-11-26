<?php
require_once 'classes/times.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];
    $descricao = $_POST['descricao'];
    $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : null;

    $times = new Times();
    $resultado = $times->editar($nome, $pais, $descricao, $imagem, $id);

    if ($resultado) {
        header("Location: index.php"); // Redireciona para a lista de times após a atualização
    } else {
        echo "Erro ao atualizar o time.";
    }
}
?>
