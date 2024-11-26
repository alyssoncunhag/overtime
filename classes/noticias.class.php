<?php
// Requer a classe de conexão com o banco de dados
require 'conexao.class.php';

class Noticias {
    private $id; // ID da notícia
    private $titulo; // Título da notícia
    private $conteudo; // Conteúdo da notícia
    private $imagem; // Imagem associada à notícia
    private $id_categorias; // Categoria da notícia (relacionada com tabela de categorias)
    private $id_autor; // Autor da notícia (relacionada com tabela de usuários)
    private $data_publicacao; // Data de publicação da notícia

    private $con; // Instância de conexão com o banco

    // Construtor da classe, cria a conexão com o banco
    public function __construct() {
        $this->con = new Conexao(); // Instancia a classe de conexão
    }

    // Função que verifica se uma notícia com o título especificado já existe no banco
    private function existeNoticia($titulo) {
        // Prepara uma consulta SQL para verificar a existência do título no banco
        $sql = $this->con->conectar()->prepare("SELECT id FROM noticias WHERE titulo = :titulo");
        $sql->bindParam(':titulo', $titulo, PDO::PARAM_STR); // Bind do parâmetro título
        $sql->execute(); // Executa a consulta

        // Se encontrar, retorna o primeiro resultado encontrado, caso contrário, retorna um array vazio
        if ($sql->rowCount() > 0) {
            return $sql->fetch(); // Retorna a primeira linha encontrada
        } else {
            return []; // Retorna um array vazio caso não encontre nenhuma notícia
        }
    }

    // Função para adicionar uma nova notícia no banco
    public function adicionar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao) {
        // Verifica se a notícia já existe
        $existeNoticia = $this->existeNoticia($titulo);
        if (empty($existeNoticia)) { // Se a notícia não existir, segue com o processo de adicionar
            try {
                // Atribui os parâmetros aos atributos da classe
                $this->titulo = $titulo;
                $this->conteudo = $conteudo;
                $this->imagem = $imagem;
                $this->id_categorias = $id_categorias;
                $this->id_autor = $id_autor;
                $this->data_publicacao = $data_publicacao;

                // Prepara a consulta SQL para inserir a notícia no banco de dados
                $sql = $this->con->conectar()->prepare("INSERT INTO noticias(titulo, conteudo, imagem, id_categorias, id_autor, data_publicacao) VALUES (:titulo, :conteudo, :imagem, :id_categorias, :id_autor, :data_publicacao)");
                $sql->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
                $sql->bindParam(":conteudo", $this->conteudo, PDO::PARAM_STR);
                $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
                $sql->bindParam(":id_categorias", $this->id_categorias, PDO::PARAM_INT);
                $sql->bindParam(":id_autor", $this->id_autor, PDO::PARAM_INT);
                $sql->bindParam(":data_publicacao", $this->data_publicacao, PDO::PARAM_STR);

                $sql->execute(); // Executa a consulta no banco
                echo "Notícia adicionada com sucesso!";
                return TRUE; // Retorna TRUE se deu tudo certo
            } catch(PDOException $ex) {
                // Exibe a mensagem de erro caso ocorra
                echo "Erro ao adicionar notícia: " . $ex->getMessage();
                return "ERRO: ".$ex->getMessage(); // Retorna o erro caso ocorra algum problema
            }
        } else {
            return FALSE; // Retorna FALSE caso a notícia já exista
        }
    }

    // Função para listar todas as notícias do banco
    public function listar() {
        try {
            // Prepara a consulta SQL para pegar todas as notícias
            $sql = $this->con->conectar()->prepare("SELECT * FROM noticias");
            $sql->execute(); // Executa a consulta
            $noticias = $sql->fetchAll(); // Pega todas as notícias
            if (empty($noticias)) {
                return [];  // Retorna um array vazio se não encontrar notícias
            }
            return $noticias; // Retorna as notícias encontradas
        } catch(PDOException $ex) {
            // Se ocorrer erro, exibe a mensagem de erro
            echo "ERRO: ".$ex->getMessage();
        }
    }

    // Função para buscar uma notícia pelo ID
    public function buscar($id) {
        try {
            // Prepara a consulta SQL para buscar a notícia pelo ID
            $sql = $this->con->conectar()->prepare("SELECT * FROM noticias WHERE id = :id");
            $sql->bindValue(':id', $id); // Faz o bind do parâmetro ID
            $sql->execute(); // Executa a consulta
            if ($sql->rowCount() > 0) {
                return $sql->fetch(); // Se encontrar, retorna os dados da notícia
            } else {
                return [];  // Retorna um array vazio caso não encontre
            }
        } catch(PDOException $ex) {
            // Exibe a mensagem de erro em caso de falha
            echo 'ERRO: '.$ex->getMessage();
        }
    }

    // Função para editar uma notícia existente
    public function editar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao, $id){
        // Verifica se a notícia com o mesmo título já existe (e se não é a mesma notícia)
        $noticiaExistente = $this->existeNoticia($titulo);
        
        if($noticiaExistente && $noticiaExistente['id'] != $id){
            return FALSE; // Retorna FALSE se a notícia com esse título já existir e não for a mesma
        } else {
            try {
                // Atualiza os dados da notícia
                $sql = $this->con->conectar()->prepare("UPDATE noticias SET titulo = :titulo, conteudo = :conteudo, id_categorias = :id_categorias, id_autor = :id_autor, data_publicacao = :data_publicacao WHERE id = :id");
                $sql->bindValue(":titulo", $titulo);
                $sql->bindValue(":conteudo", $conteudo);
                $sql->bindValue(":id_categorias", $id_categorias);
                $sql->bindValue(":id_autor", $id_autor);
                $sql->bindValue(":data_publicacao", $data_publicacao);
                $sql->bindValue(":id", $id);
                $sql->execute(); // Executa a consulta de atualização
    
                // Se uma imagem for enviada, processa e salva no banco
                if (isset($imagem['tmp_name']) && !empty($imagem['tmp_name']) && is_array($imagem['tmp_name'])) {
                    // Processa a imagem (redimensionamento e move para o diretório de imagens)
                    for ($q = 0; $q < count($imagem['tmp_name']); $q++) {
                        $tipo = $imagem['type'][$q]; // Tipo de imagem
                        if (in_array($tipo, ['image/jpeg', 'image/png'])) { // Se for imagem JPEG ou PNG
                            $tmpname = md5(time() . rand(0, 9999)) . '.jpg'; // Cria um nome único para a imagem
                            if (is_uploaded_file($imagem['tmp_name'][$q])) {
                                move_uploaded_file($imagem['tmp_name'][$q], 'img/noticias/' . $tmpname); // Move a imagem

                                // Redimensiona a imagem
                                list($width_orig, $height_orig) = getimagesize('img/noticias/' . $tmpname);
                                $ratio = $width_orig / $height_orig;
    
                                $width = 500;
                                $height = 500;
    
                                if ($width / $height > $ratio) {
                                    $width = $width * $ratio;
                                } else {
                                    $height = $width / $ratio;
                                }
    
                                $img = imagecreatetruecolor($width, $height);
                                if ($tipo === 'image/jpeg') {
                                    $origi = imagecreatefromjpeg('img/noticias/' . $tmpname);
                                } elseif ($tipo === 'image/png') {
                                    $origi = imagecreatefrompng('img/noticias/' . $tmpname);
                                }
                                imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                                imagejpeg($img, 'img/noticias/' . $tmpname, 80); // Salva a imagem redimensionada

                                // Insere a imagem no banco
                                $sql = $this->con->conectar()->prepare("INSERT INTO imagem_noticia (id_noticia, url) VALUES (:id_noticia, :url)");
                                $sql->bindValue(":id_noticia", $id);
                                $sql->bindValue(":url", $tmpname);
                                $sql->execute(); // Executa a inserção da imagem
                            }
                        }
                    }
                }
    
                return TRUE; // Retorna TRUE se a edição foi bem-sucedida
            } catch (PDOException $ex) {
                echo 'ERRO: ' . $ex->getMessage(); // Exibe erro em caso de falha
            }
        }
    }

    // Função para deletar uma notícia do banco
    public function deletar($id) {
        // Prepara a consulta SQL para deletar a notícia
        $sql = $this->con->conectar()->prepare("DELETE FROM noticias WHERE id = :id");
        $sql->bindValue(":id", $id); // Faz o bind do ID
        $sql->execute(); // Executa a consulta para deletar
    }
}
?>
