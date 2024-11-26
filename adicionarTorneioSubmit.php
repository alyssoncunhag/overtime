<?php
include 'classes/torneios.class.php';

$torneio = new Torneios();

if (!empty($_POST['nome']) && !empty($_POST['id_jogos'])) {
    $nome = $_POST['nome'];
    $id_jogos = $_POST['id_jogos'];  // Corrigido
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Processar a imagem
    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Definir o diretório para salvar a imagem
        $diretorio = 'img/torneios/';
        $nome_imagem = $_FILES['imagem']['name'];
        $caminho_imagem = $diretorio . basename($nome_imagem);
        
        // Mover a imagem para o diretório
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            $imagem = $nome_imagem;  // Nome da imagem que será salva no banco
        } else {
            echo '<script type="text/javascript">alert("Erro no upload da imagem!");</script>';
        }
    }

    // Agora, chamar o método da classe Torneios para adicionar o torneio
    $resultado = $torneio->adicionar($nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem);

    if ($resultado) {
        header('Location: index.php');  // Redireciona para a página inicial
    } else {
        echo '<script type="text/javascript">alert("Torneio já cadastrado ou campos obrigatórios não preenchidos!");</script>';
    }
} else {
    echo '<script type="text/javascript">alert("Torneio já cadastrado ou campos obrigatórios não preenchidos!");</script>';
}
?>
