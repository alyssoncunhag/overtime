<?php
session_start();
include 'classes/noticias.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}


$noticia = new Noticias();

?>

<h1>Gestão de Notícias</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
    <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Conteudo</th>
        <th>Imagem</th>
        <th>ID Categoria</th>
        <th>ID Autor</th>
        <th>Data de Publicação</th>
    </tr>
<?php
$lista = $noticia->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['titulo']?></td>
        <td><?php echo $item['conteudo']?></td>
        <td><?php echo $item['imagem']?></td>
        <td><?php echo $item['id_categoria']?></td>
        <td><?php echo $item['id_autor']?></td>
        <td><?php echo $item['data_publicacao']?></td>
            <a href="#">Editar</a>
            <a href="#"> | Excluir</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>