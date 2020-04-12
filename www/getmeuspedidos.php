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


$sql = 'select p.descricao as descricaopedido, ts.descricao as tiposervico, t.nome as nometecnico,* from cerma.pedidos p
left join tecnico t on cast(fk_tecnico as int) = t.idtecnico
, tiposervico ts, situacaopedido sp
where
p.idsituacaopedido = sp.idsituacaopedido and
cast(p.fk_tiposervico as int) = ts.idtiposervico and
p.codpessoa = '.$id;
$sql.=' order by p.idpedido desc';
$sql.= ' limit 50  ';

$res = pg_exec($conn,$sql);
$dir = "./upload"; 

// esse seria o "handler" do diretório
$dh = opendir($dir); 

?>
<h4>Meus Pedidos</h4>
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
									$imagem = '<img src="https://cerma.jbrj.gov.br/upload/'.$filename.'" width="60px" class="img-thumbnail">'; 
								}
							}
						}
											  
					  
					  
					  $cor = 'default';
					  if ($row['idsituacaopedido']=='1'){ $cor = 'success'; $sb = '';}
					  if ($row['idsituacaopedido']=='2'){ $cor = 'warning'; $sb = ''; }
					  if ($row['idsituacaopedido']=='3'){ $cor = 'danger'; $sb = ''; }
					  if ($row['idsituacaopedido']=='4'){ $cor = 'default'; $sb = 'disabled'; }
					  if ($row['idsituacaopedido']=='5'){ $cor = 'default'; $sb = 'disabled';}
					  if ($row['idsituacaopedido']=='6'){ $cor = 'default'; $sb = 'disabled'; }
					  
					  ?>
					<div class="panel panel-<?php echo $cor;?>">
						  <div class="panel-heading"><?php echo "Nº ".$row['idpedido'].'/'.$row['ano'].' - '.utf8_encode($row['tiposervico']).' - '.date('d/m/Y',strtotime($row['datainicio']));?></div>
						  <div class="panel-body">
						  <div class="card">
							<div class="card-body">
								<h4 class="card-title"></h4>
								<p class="card-text">
								<?php echo $imagem;?>
								<p><b>Local/Sala: </b><?php echo utf8_encode($row['local']);?>/<?php echo utf8_encode($row['sala']);?><br>
								<b>Descrição: </b><?php echo $row['descricaopedido'];?><br>
								<?php if (!empty($row['solucao']))
								{
								?>
								<b>Atendimento: </b><?php echo $row['solucao'];?><br>
								<b>Tecnico: </b><?php echo $row['nometecnico'];?><br>
								<b>Data: </b><?php echo date('d/m/Y',strtotime($row['solucao']));?></p>
								<?php	
								}
								?>
								<div class="alert alert-success"><strong>Situação: </strong><?php echo $row['situacaopedido'];?></div>
								
								<a onclick="confirmarAtendimento(<?php echo $row['idpedido'];?>)" class="btn btn-info btn-md <?php echo $sb;?>">
									<span class="glyphicon glyphicon-pencil"></span> 
								</a>
								<a onclick="cancelarPedido(<?php echo $row['idpedido'];?>)" class="btn btn-warning btn-md <?php echo $sb;?>">
									<span class="glyphicon glyphicon-remove"></span> 
								</a>
								<a onclick="excluirPedido(<?php echo $row['idpedido'];?>)" class="btn btn-danger btn-md <?php echo $sb;?>">
									<span class="glyphicon glyphicon-trash"></span> 
								</a>

							</div>
						  </div>
					  </div>
					</div>
				  <?php } ?>