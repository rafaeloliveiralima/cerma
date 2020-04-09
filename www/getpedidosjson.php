<?php
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$operacao = $_REQUEST['op'];
$id = $_REQUEST['id'];

$sql = 'select * from cerma.pedidos where idpedido = '.$id;
$res = pg_exec($conn,$sql);
$row = pg_fetch_array($res);


$myObj->idpedido = utf8_encode($row['idpedido']);
$myObj->solicitante= utf8_encode($row['nome']);
$myObj->telefone= utf8_encode($row['telefone']);
$myObj->email= utf8_encode($row['email']);
$myObj->local= utf8_encode($row['local']);
$myObj->sala= utf8_encode($row['sala']);
$myObj->ano= utf8_encode($row['ano']);
$myObj->descricao= utf8_encode($row['descricao']);
$myObj->datafim= utf8_encode($row['datafim']);
$myObj->idprioridade= utf8_encode($row['idprioridade']);
$myObj->idsituacaopedido= utf8_encode($row['idsituacaopedido']);
$myJSON = json_encode($myObj);

echo $myJSON;
?>