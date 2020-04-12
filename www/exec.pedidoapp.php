<?php
require_once('classes/conexao.class.php');
require_once('classes/pedido.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$Classe = new Pedido(); // <-- Alterar o nome da classe
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
$id = $_REQUEST['id'];

if ($operacao == 'I')  {

    $idusuario = $_REQUEST['idusuario'];
	$solicitante = $_REQUEST['solicitante'];
    $telefone = $_REQUEST['telefone'];
    $email = $_REQUEST['email'];
    $setor = $_REQUEST['setor'];
    $local = $_REQUEST['local'];
    $sala = $_REQUEST['sala'];
    $idtiposervico = $_REQUEST['idtiposervico'];
    $descricao = $_REQUEST['descricao'];
	
    $Classe->codpessoa = pg_escape_string(utf8_decode(trim($idusuario)));
    $Classe->nome = pg_escape_string(utf8_decode(trim($solicitante)));
    $Classe->telefone = pg_escape_string(utf8_decode(trim($telefone)));
    $Classe->email = pg_escape_string(utf8_decode(trim($email)));
    $Classe->setor = pg_escape_string(utf8_decode(trim($setor)));
    $Classe->local = pg_escape_string(utf8_decode(trim($local)));
    $Classe->sala = pg_escape_string(utf8_decode(trim($sala)));
    $Classe->idtiposervico = pg_escape_string(utf8_decode(trim($idtiposervico)));
    $Classe->descricao = pg_escape_string(trim(utf8_encode($descricao)));
	
    $result = $Classe->incluirAPP();
	
	if ($result!=0)
	{
		/*$Classe->getById($result);
		
		$msg_telegram = 'Animal Cadastrado! '.chr(10);
		$msg_telegram .= 'ID: '.$Classe->idanimal. chr(10);
		$msg_telegram .= 'Nome: '.$Classe->nome. chr(10);
		$msg_telegram .= 'Nome científico: '.$Classe->nomecientifico. chr(10);
		$msg_telegram .= 'Microchip: '.$Classe->microchip. chr(10);
		//$msg_telegram .= 'Número: '.$Classe->numeroanimal.'/'.$Classe->anoanimal. chr(10);
		$msg_telegram = $msg_telegram;
		$apiToken = "585866996:AAGl018A9au_2Qtw05ql4s4p-HTacPODNv4";
		$data= array ('chat_id' => '@fauna_jb','text' => $msg_telegram);
		$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
		*/
	}
	echo $result;
}	

if ($operacao == 'AA')  {

    $idusuario = $_REQUEST['idusuario'];
    $idpedido = $_REQUEST['idpedido'];
    $atendimento = $_REQUEST['atendimento'];
    $material = $_REQUEST['material']; // ainda não foi criado na tabela
	$idtecnico = $idusuario; // o usuário é quem vai ficar como o técnico do sistema
	$idsituacao = $_REQUEST['idsituacao'];
	
    $Classe->idsituacaopedido = pg_escape_string(utf8_decode(trim($idsituacao)));
    $Classe->idtecnico = pg_escape_string(utf8_decode(trim($idtecnico)));
    $Classe->material = pg_escape_string(utf8_decode(trim($material)));
    $Classe->atendimento = pg_escape_string(utf8_decode(trim($atendimento)));
	
    $result = $Classe->alterarAPP($idpedido);
	
	if ($result!=0)
	{
		/*$Classe->getById($result);
		
		$msg_telegram = 'Animal Cadastrado! '.chr(10);
		$msg_telegram .= 'ID: '.$Classe->idanimal. chr(10);
		$msg_telegram .= 'Nome: '.$Classe->nome. chr(10);
		$msg_telegram .= 'Nome científico: '.$Classe->nomecientifico. chr(10);
		$msg_telegram .= 'Microchip: '.$Classe->microchip. chr(10);
		//$msg_telegram .= 'Número: '.$Classe->numeroanimal.'/'.$Classe->anoanimal. chr(10);
		$msg_telegram = $msg_telegram;
		$apiToken = "585866996:AAGl018A9au_2Qtw05ql4s4p-HTacPODNv4";
		$data= array ('chat_id' => '@fauna_jb','text' => $msg_telegram);
		$response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
		*/
	}
	echo $result;
}	



if ($operacao == 'CP') {
	$id = $_REQUEST['id'];
    $result = $Classe->cancelarPedidoAPP($id);
	echo $result;
}

if ($operacao == 'E') {
	$id = $_REQUEST['id'];
    $result = $Classe->excluirAPP($id);
	echo $result;
}
	
?>