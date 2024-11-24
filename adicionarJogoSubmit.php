<?php
include 'classes/jogos.class.php';
$jogo = new Jogos();

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_lancamento = $_POST['data_lancamento'];
    $imagem = $_POST['imagem'];
    $jogo->adicionar($nome, $descricao, $data_lancamento, $imagem);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Jogo já cadastrado!");<script>';
}