<?php
// Inclui o arquivo da classe Torneios para poder instanciá-la e usar seus métodos
include 'classes/torneios.class.php';

// Instancia a classe Torneios
$torneio = new Torneios();

// Verifica se os campos obrigatórios (nome e id_jogos) foram preenchidos no formulário
if (!empty($_POST['nome']) && !empty($_POST['id_jogos'])) {
    // Atribui os dados recebidos do formulário às variáveis
    $nome = $_POST['nome'];
    $id_jogos = $_POST['id_jogos'];  // Atribui o ID do jogo ao torneio
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Inicializa a variável de imagem como null
    $imagem = null;

    // Verifica se um arquivo de imagem foi enviado e não há erros
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Define o diretório onde a imagem será salva
        $diretorio = 'img/torneios/';
        // Pega o nome da imagem
        $nome_imagem = $_FILES['imagem']['name'];
        // Define o caminho completo para salvar a imagem
        $caminho_imagem = $diretorio . basename($nome_imagem);
        
        // Tenta mover a imagem para o diretório especificado
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            // Se o upload for bem-sucedido, atribui o nome da imagem à variável $imagem
            $imagem = $nome_imagem;  // Nome da imagem que será armazenado no banco de dados
        } else {
            // Se ocorrer um erro no upload da imagem, exibe uma mensagem de erro
            echo '<script type="text/javascript">alert("Erro no upload da imagem!");</script>';
        }
    }

    // Chama o método adicionar da classe Torneios, passando os dados para inserir o torneio
    $resultado = $torneio->adicionar($nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem);

    // Verifica se o torneio foi adicionado com sucesso
    if ($resultado) {
        // Se foi adicionado com sucesso, redireciona para a página inicial
        header('Location: index.php');
    } else {
        // Se houver erro (como torneio já cadastrado ou campos obrigatórios faltando), exibe um alerta
        echo '<script type="text/javascript">alert("Torneio já cadastrado ou campos obrigatórios não preenchidos!");</script>';
    }
} else {
    // Se os campos obrigatórios não foram preenchidos, exibe um alerta
    echo '<script type="text/javascript">alert("Torneio já cadastrado ou campos obrigatórios não preenchidos!");</script>';
}
?>
