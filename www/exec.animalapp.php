<?php
//session_start();
require_once('classes/conexao.class.php');
require_once('classes/animal.class.php');

//if (!isset($_SESSION['s_idusuario'])) {
 //   header("Location: index.php");
//}

$conexao = new Conexao;
$conn = $conexao->Conectar();

$Classe = new Animal(); // <-- Alterar o nome da classe
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
$id = $_REQUEST['id'];

if ($operacao == 'I')  {

    $nome = $_REQUEST['nomeanimal'];
    $nomecientifico = $_REQUEST['nomecientifico'];
    $microchipanimal = $_REQUEST['microchipanimal'];
    $idclasseetaria = $_REQUEST['classeetariaanimal'];
    $idsexo = $_REQUEST['sexoanimal'];
    $idtipoanimal = $_REQUEST['tipoanimal'];
    $idsituacaoanimal = $_REQUEST['situacaoanimal'];
    $observacaoanimal = $_REQUEST['observacaoanimal'];
	
    $Classe->nome = pg_escape_string(utf8_decode(trim($nome)));
    $Classe->idclasseetaria = pg_escape_string(utf8_decode(trim($idclasseetaria)));
    $Classe->idsexo = pg_escape_string(utf8_decode(trim($idsexo)));
    $Classe->idtipoanimal = pg_escape_string(utf8_decode(trim($idtipoanimal)));
    $Classe->idsituacaoanimal = pg_escape_string(utf8_decode(trim($idsituacaoanimal)));
    $Classe->microchip = pg_escape_string(utf8_decode(trim($microchipanimal)));
    $Classe->observacao = pg_escape_string(utf8_decode(trim($observacaoanimal)));
    $Classe->nomecientifico = pg_escape_string($nomecientifico);	

	
    $result = $Classe->incluir();
	
	if ($result!=0)
	{
		$Classe->getById($result);
		
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
	}
	
	echo $result;
}	


if ($operacao == 'E') {
	
    if (!empty($id)) {
        $result = $Classe->excluir($id);
		echo $result;
    }
}
	
?>