<?php
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$operacao = $_REQUEST['op'];
$id = $_REQUEST['idusuario'];
$filtro = $_REQUEST['filtro'];

$operacao = preg_replace('/[^[:alpha:]_]/', '',$operacao);
$filtro = preg_replace('/[^[:alpha:]_]/', '',$filtro);
settype($id, 'integer');

$sql = 'select p.descricao as descricaopedido, ts.descricao as tiposervico,* from cerma.pedidos p, tiposervico ts, situacaopedido sp 
where
p.idsituacaopedido = sp.idsituacaopedido and
cast(p.fk_tiposervico as int) = ts.idtiposervico and p.idsituacaopedido in (1,2,3) ';

$sql.= ' limit 50 ';

$res = pg_exec($conn,$sql);
$dir = "./upload"; 

// esse seria o "handler" do diretório
$dh = opendir($dir); 

?>
<h4>Pedidos para Atendimento</h4>
				  <?php 
				  while ($row=pg_fetch_array($res))
				  {
					  
					  $id=str_pad($row['idpedido'], 4, "0", STR_PAD_LEFT);
					
					// loop que busca todos os arquivos até que não encontre mais nada
						$imagem = '';
						rewinddir();
						while (false !== ($filename = readdir($dh))) { 
						// verificando se o arquivo é .jpg
							if (substr($filename,-4) == ".jpg") { 
							// mostra o nome do arquivo e um link para ele - pode ser mudado para mostrar diretamente a imagem :)
								if (substr($filename,0,4) == $id) { 
									$imagem = '<img src="http://cerma.jbrj.gov.br/upload/'.$filename.'" width="100px" class="img-thumbnail">'; 
								}
							}
						}
											  
					  
					  
					  $cor = 'success';
					  if ($row['idprioridade']=='3'){ $cor = 'success'; }
					  if ($row['idprioridade']=='2'){ $cor = 'warning'; }
					  if ($row['idprioridade']=='1'){ $cor = 'danger'; }

					  $cors = 'default';
					  if ($row['idsituacaopedido']=='1'){ $cors = 'success'; $sbc = '';}
					  if ($row['idsituacaopedido']=='2'){ $cors = 'warning'; $sbc = ''; }
					  if ($row['idsituacaopedido']=='3'){ $cors = 'danger'; $sbc = ''; }
					  if ($row['idsituacaopedido']=='4'){ $cors = 'default'; $sbc = ''; }
					  if ($row['idsituacaopedido']=='5'){ $cors = 'default'; $sbc = '';}
					  if ($row['idsituacaopedido']=='6'){ $cors = 'default'; $sbc = ''; }
					  
					  
					  ?>
					<div class="panel panel-<?php echo $cor;?>">
						  <div class="panel-heading"><?php echo "Nº ".$row['idpedido'].'/'.$row['ano'].' - '.utf8_encode($row['tiposervico']).' - '.date('d/m/Y',strtotime($row['datainicio']));?></div>
						  <div class="panel-body">
						  <div class="card">
							<div class="card-body">
								<h4 class="card-title"></h4>
								<p class="card-text">
								<?php echo $imagem;?>
								<p><b>Solicitante: </b><?php echo utf8_encode($row['nome']);?><br>
								<b>Telefone: </b><?php echo utf8_encode($row['telefone']);?><br>
								<b>Local: </b><?php echo utf8_encode($row['local']);?>/Sala: </b><?php echo utf8_encode($row['sala']);?><br>
								<b>Descrição: </b><?php echo $row['descricaopedido'];?></p>
								<div class="alert alert-success"><strong>Situação: </strong><?php echo $row['situacaopedido'];?></div>
								<a onclick="abreCamera('CAMERA','PEDIDO','<?php echo $row['idpedido'];?>')" class="btn btn-success btn-md">
									<span class="glyphicon glyphicon-camera"></span> 
								</a>
								<a onclick="abreCamera('ARQUIVO','PEDIDO','<?php echo $row['idpedido'];?>')" class="btn btn-info btn-md">
									<span class="glyphicon glyphicon-file"></span> 
								</a>
								<a onclick="abreAtedimento(<?php echo $row['idpedido'];?>)" class="btn btn-danger btn-md">
									<span class="glyphicon glyphicon-edit"></span> 
								</a>
								<a onclick="confirmarAtendimento(<?php echo $row['idpedido'];?>)" class="btn btn-warning btn-md <?php echo $sbc;?>">
									<span class="glyphicon glyphicon-pencil"></span> 
								</a>
							</div>
						  </div>
					  </div>
					</div>
				  <?php } ?>