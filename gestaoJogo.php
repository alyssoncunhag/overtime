<?php
session_start();
include 'classes/jogos.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}


$jogo = new Jogos();

?>

<h1>Gestão de Jogos</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Data de Lançamento</th>
        <th>Imagem</th>
    </tr>
<?php
$lista = $jogo->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['descricao']?></td>
        <td><?php echo $item['data_lancamento']?></td>
        <td><?php echo $item['imagem']?></td>
            <a href="#">Editar</a>
            <a href="#"> | Excluir</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>