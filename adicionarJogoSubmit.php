<?php
include 'classes/jogos.class.php';
$jogo = new Jogos();

if (isset($_POST['btCadastrar'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_lancamento = $_POST['data_lancamento'];
    $imagem = $_FILES['imagem'];  // Alterado para pegar o arquivo de imagem
    $resultado = $jogo->adicionar($nome, $descricao, $data_lancamento, $imagem);

    if ($resultado === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo '<script type="text/javascript">alert("Erro ao adicionar o jogo!");</script>';
    }
} else {
    echo '<script type="text/javascript">alert("Jogo já cadastrado!");</script>';
}
?>
