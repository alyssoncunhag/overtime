<?php
session_start();
include 'classes/torneios.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}

$torneio = new Torneios();

?>

<h1>Gestão de Torneios</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>ID Jogo</th>
        <th>Descrição</th>
        <th>Data Inicio</th>
        <th>Data Fim</th>
    </tr>
<?php
$lista = $torneio->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['id_jogo']?></td>
        <td><?php echo $item['descricao']?></td>
        <td><?php echo $item['data_inicio']?></td>
        <td><?php echo $item['data_fim']?></td>
            <a href="#">Editar</a>
            <a href="#"> | Excluir</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>