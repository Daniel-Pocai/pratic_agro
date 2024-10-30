<?
$hash = Garbage::getHash();
?>
<style>
	.excluido{text-decoration:line-through;}
</style>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3>Excluir <?=$model->label();?></h3>
</div>

<div class="modal-body">
                 
	<?
    $array_relacionados = $model->getRelationData();
	$name = $model->representingName();
	
	function imprimirRelacionados($relacionados){
		foreach($relacionados as $modulo => $registros){	
			?> 
            <strong><?=Util::formataTexto($modulo)?></strong>                  
			<ul>
				
				<?
				foreach($registros as $registro){
					$controller = get_class($registro);
					$controller[0] = strtolower($controller[0]);
					
					$array_relacionados_registro = $registro->getRelationData();
					$relacionados = count($array_relacionados_registro) > 0 ? 'com-relacionados' : 'sem-relacionados';
					?>
					<li class="item-excluir pendente <?=$relacionados?> item-<?=$registro->tableName()?>-<?=$registro->primaryKey?>" data-id="<?=$registro->primaryKey?>" data-table="<?=$registro->tableName()?>" data-ref="<?php echo Yii::app()->createUrl($controller.'/delete',array('id'=>$registro->primaryKey));?>">
						
                        <a href="<?php echo Yii::app()->createUrl($controller.'/view',array('id'=>$registro->primaryKey));?>" target="_blank"><?=Util::formataTexto($registro->representingName());?></a>
                    	
						<?
						if($relacionados == 'com-relacionados'){
							imprimirRelacionados($array_relacionados_registro);
						}
						?>
                        
                    </li>
					<?
				}
				?>
			</ul>
			<?
		}
	}
	if(count($array_relacionados) > 0){
		?>
		<p>O registro "<strong><?=$name?></strong>" possui itens relacionados:</p>
		<div style="margin-left:10px;">
			<?
            imprimirRelacionados($array_relacionados);
            ?>
        </div>
		<p>Para efetivar a exclusão será necessário excluir os itens relacionados ou remover a relação.</p>
        <?
	}
	else{
		?>
		<p>Você tem certeza que deseja excluir "<strong><?=$name?></strong>"?</p>
		<?
	
	}
    ?>
</div>
<div class="modal-footer">
      <a data-id="<?=$model->getPrimaryKey()?>" href="<?php echo $this->createUrlRel('delete',array('id'=>$_GET['id'],'confirm'=>'1'));?>" class="btn btn-danger excluir-confirmacao"><i class="icon-trash"></i>
      <i class="fa fa-trash-o"></i> 
	  <?
      if(count($array_relacionados) == 0){
          ?>
           Sim
          <?
      }
      else{
          ?>
          Sim, desejo excluir todos os itens
          <?
      }
      ?>
      </a>
      <a href="#" data-dismiss="modal" class="btn btn-default btn-close">Cancelar</a>
</div>
