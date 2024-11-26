<?php
// Incluindo a classe 'Jogos' que contém os métodos necessários para manipulação de jogos
include 'classes/jogos.class.php';

// Instanciando a classe 'Jogos' para usar seus métodos
$jogo = new Jogos();

// Verifica se o formulário foi enviado (quando o botão de cadastro é pressionado)
if (isset($_POST['btCadastrar'])) {
    // Pegando os valores enviados do formulário
    $nome = $_POST['nome']; // Nome do jogo
    $descricao = $_POST['descricao']; // Descrição do jogo
    $data_lancamento = $_POST['data_lancamento']; // Data de lançamento do jogo
    $imagem = $_FILES['imagem'];  // Acessando o arquivo de imagem enviado pelo formulário

    // Chama o método adicionar da classe Jogos e passa os dados para adicionar o jogo
    $resultado = $jogo->adicionar($nome, $descricao, $data_lancamento, $imagem);

    // Verifica se o jogo foi adicionado com sucesso
    if ($resultado === TRUE) {
        // Se foi adicionado com sucesso, redireciona o usuário para a página inicial (index.php)
        header('Location: index.php');
        exit();
    } else {
        // Se ocorreu algum erro ao adicionar o jogo, exibe uma mensagem de erro
        echo '<script type="text/javascript">alert("Erro ao adicionar o jogo!");</script>';
    }
} else {
    // Caso o formulário já tenha sido enviado e o jogo já tenha sido cadastrado, exibe uma mensagem de erro
    echo '<script type="text/javascript">alert("Jogo já cadastrado!");</script>';
}
?>
