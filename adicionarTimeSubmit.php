<?php
include 'classes/times.class.php';  // Incluindo o arquivo correto
$time = new Times();  // Instanciando a classe corretamente

if(!empty($_POST['nome'])){
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];
    $time->adicionar($nome, $pais, $descricao, $imagem);  // Chamando o método adicionar
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Time já cadastrado!");</script>';
}
