<?php
// Incluir a classe de jogos
require_once 'classes/jogos.class.php';

$jogo = new Jogos();

// Verificar se todos os campos obrigatórios foram enviados
if (
    isset($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['data_lancamento']) &&
    !empty($_POST['nome']) && !empty($_POST['descricao']) && !empty($_POST['data_lancamento'])
) {
    // Sanitizar os dados recebidos
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
    $data_lancamento = filter_var($_POST['data_lancamento'], FILTER_SANITIZE_STRING);

    // Verificar se foi enviada uma imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // Validar o tipo da imagem (somente JPG, JPEG e PNG)
        $imagem = $_FILES['imagem'];
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $tiposPermitidos = ['jpg', 'jpeg', 'png'];

        if (!in_array(strtolower($extensao), $tiposPermitidos)) {
            // Se a imagem não for válida, redireciona com erro
            header("Location: index.php?error=2");
            exit;
        }
    } else {
        $imagem = null; // Sem imagem enviada
    }

    // Atualizar o jogo usando a classe Jogos
    $editar = $jogo->editar($nome, $descricao, $data_lancamento, $imagem, $id);

    if ($editar) {
        // Redirecionar para o índice após a atualização com sucesso
        header("Location: index.php?success=1");
        exit;
    } else {
        // Redirecionar para o índice com mensagem de erro ao atualizar
        header("Location: index.php?error=1");
        exit;
    }
} else {
    // Redirecionar para o índice com mensagem de erro caso algum campo obrigatório esteja faltando
    header("Location: index.php?error=1");
    exit;
}
?>
