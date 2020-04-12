<?php
require_once('classes/conexao.class.php');
require_once('classes/setor.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$Classe = new Setor();
$Classe->conn = $conn;
$nomecombo = $_REQUEST['nomecombo'];
if (empty($nomecombo))
{
	$nomecombo='cmboxsetor']
}
echo $Classe->listaCombo($nomecombo, '', 'N', 'class="form-control input-sm"');
 ?>				  

