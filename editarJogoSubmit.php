<?php
// Incluir a classe de jogos, que contém os métodos necessários para manipulação de jogos no banco de dados
require_once 'classes/jogos.class.php';

// Cria um objeto da classe Jogos para interagir com o banco de dados
$jogo = new Jogos();

// Verificar se todos os campos obrigatórios foram enviados via POST e se não estão vazios
if (
    isset($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['data_lancamento']) && // Verifica se os campos necessários foram enviados
    !empty($_POST['nome']) && !empty($_POST['descricao']) && !empty($_POST['data_lancamento']) // Verifica se os campos não estão vazios
) {
    // Sanitizar os dados recebidos para evitar injeções de código malicioso
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT); // Sanitiza o ID para garantir que seja um número inteiro
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING); // Sanitiza o nome removendo caracteres especiais
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING); // Sanitiza a descrição
    $data_lancamento = filter_var($_POST['data_lancamento'], FILTER_SANITIZE_STRING); // Sanitiza a data de lançamento

    // Verificar se foi enviada uma imagem para ser associada ao jogo
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) { 
        // Verifica se houve erro no upload da imagem e se o arquivo foi carregado com sucesso

        // Validar o tipo da imagem (somente arquivos de imagem JPG, JPEG e PNG são permitidos)
        $imagem = $_FILES['imagem']; // Pega o arquivo da imagem
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION); // Extrai a extensão do arquivo da imagem
        $tiposPermitidos = ['jpg', 'jpeg', 'png']; // Tipos de imagem permitidos

        // Verifica se a extensão do arquivo da imagem está na lista de tipos permitidos
        if (!in_array(strtolower($extensao), $tiposPermitidos)) {
            // Se a imagem não for válida, redireciona com código de erro 2 (tipo de imagem inválido)
            header("Location: index.php?error=2");
            exit; // Interrompe a execução do código
        }
    } else {
        // Se nenhuma imagem for enviada, a variável $imagem é definida como null
        $imagem = null;
    }

    // Chama o método de edição da classe Jogos para atualizar as informações do jogo no banco de dados
    $editar = $jogo->editar($nome, $descricao, $data_lancamento, $imagem, $id);

    // Verifica se a edição foi bem-sucedida
    if ($editar) {
        // Se a edição for bem-sucedida, redireciona para o índice com parâmetro de sucesso
        header("Location: index.php?success=1");
        exit; // Interrompe a execução do código
    } else {
        // Se houve erro ao editar o jogo, redireciona para o índice com parâmetro de erro
        header("Location: index.php?error=1");
        exit; // Interrompe a execução do código
    }
} else {
    // Se algum campo obrigatório estiver faltando ou vazio, redireciona para o índice com parâmetro de erro
    header("Location: index.php?error=1");
    exit; // Interrompe a execução do código
}
?>
