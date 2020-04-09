<?php
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();

$operacao = $_REQUEST['op'];
$id = $_REQUEST['idusuario'];
$filtro = $_REQUEST['filtro'];

$sql = 'select p.descricao as descricaopedido, ts.descricao as tiposervico,* from cerma.pedidos p, tiposervico ts 
where
cast(p.fk_tiposervico as int) = ts.idtiposervico and
p.codpessoa = 19577 ';

$sql.= ' limit 50 ';

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
									$imagem = '<img src="https://croma.jbrj.gov.br/CERMA2.0/upload/'.$filename.'" width="60px" class="img-thumbnail">'; 
								}
							}
						}
											  
					  
					  
					  $cor = 'default';
					  if ($row['idsituacaopedido']=='3'){ $cor = 'success'; }
					  if ($row['idsituacaopedido']=='2'){ $cor = 'warning'; }
					  if ($row['idsituacaopedido']=='1'){ $cor = 'danger'; }
					  
					  ?>
					<div class="panel panel-<?php echo $cor;?>">
						  <div class="panel-heading"><a onclick='carregaatendimento(<?php echo $row['idpedido'];?>)'><?php echo "Nº ".$row['idpedido'].'/'.$row['ano'].' - '.utf8_encode($row['tiposervico']).' - '.date('d/m/Y',strtotime($row['datainicio']));?></a></div>
						  <div class="panel-body">
						  <div class="card">
							<div class="card-body">
								<h4 class="card-title"></h4>
								<p class="card-text">
								<?php echo $imagem;?>
								<p><b>Local: </b><?php echo utf8_encode($row['local']);?></p>
								<p><b>Sala: </b><?php echo utf8_encode($row['sala']);?></p>
								<p><b>Descrição: </b><?php echo utf8_encode($row['descricaopedido']);?></p>
								<a onclick="confirmarAtendimento(<?php echo $row['idpedido'];?>)" class="btn btn-warning btn-md">
									<span class="glyphicon glyphicon-pencil"></span> 
								</a>
								<a onclick="cancelarPedido(<?php echo $row['idpedido'];?>)" class="btn btn-danger btn-md">
									<span class="glyphicon glyphicon-remove"></span> 
								</a>

							</div>
						  </div>
					  </div>
					</div>
				  <?php } ?>