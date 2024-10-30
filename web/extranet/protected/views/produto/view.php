<?php
$this->breadcrumbs[$model->label(2)] = array('index');
if($this->hasRel()){
	$this->breadcrumbs[$model->label(2)] = array('rel'=>$this->getRel());
}
$this->breadcrumbs[] = Yii::t('app','Visualizar');

$form = new GxActiveForm();


if(isset($_GET['success'])){
	
	$msg = "Cadastro atualizado com sucesso!";
	if($_GET['success'] == 'create'){
		$msg = "Cadastro realizado com sucesso!";
	}
	
	Yii::app()->clientScript->registerScript('helpers', '                                                           
		swal("'.$msg.'", "Confira os dados", "success");                                                                                                          
	',2);
}

?><div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> Visualizar <?=Util::formataTexto($model->label(1));?>          <?
          if(!Yii::app()->user->isGuest){
              $this->renderPartial("//layouts/caminho");
          }
          ?> 
      </h3>
      <hr/>
    </div>
</div>
<div class="row">
	<div class="col-md-9 col-sm-12">
		<div class="panel panel-default">
        
        
        <div class="grid-structure">
          
          <?
		  if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'create')){
			  ?>			  <div style="margin-bottom:20px;">
				  <a href="<?=$this->createUrlRel('create');?>" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar <?=$model->label(1);?></a>
			  </div>
			  <?
		  }
		  ?>          
			<div class="row">
				<div class="col-md-2">
					<?=Util::formataTexto($model->getAttributeLabel('posicao'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->posicao)?>      
					</div>
				</div>
				<div class="col-md-5">
					<?=Util::formataTexto($model->getAttributeLabel('idcategoria'));?></dt>
					<div class="grid-container">
						<?=($model->categoria !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->categoria)), array('categoria/view', 'id' => GxActiveRecord::extractPkValue($model->categoria, true)),array('class' => 'relational-link')) : null)?>          
					</div>
				</div>
				<div class="col-md-5">
					<?=Util::formataTexto($model->getAttributeLabel('nome'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->nome)?>         
					</div>
				</div>
			</div>
			
            <div class="row">
				<div class="col-md-12">
					<?=Util::formataTexto($model->getAttributeLabel('subtitulo'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->subtitulo)?>  
					</div>
				</div>
           	</div>
			<div class="row">
                <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('tipo'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->getTipo())?>                 	
					</div>
               	</div>
           	</div>
                    		            
            <div class="row">
                <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('descricao'));?></dt>
                    <div class="grid-container">
				  		<?=$model->descricao?>        
					</div>
               	</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<?=Util::formataTexto($model->getAttributeLabel('apresentacao'));?></dt>
					<div class="grid-container">
						<ul>
							<?php 
							$apresentacoes = explode(',', $model->apresentacao);
							foreach ($apresentacoes as $item) {
								echo '<li>' . Util::formataTexto(trim($item)) . '</li>';
							}
							?>
						</ul>                	
					</div>
				</div>
                <div class="col-md-4">
				  	<?=Util::formataTexto($model->getAttributeLabel('embalagem'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->embalagem)?>                 	
					</div>
               	</div>
				<div class="col-md-4">
					<?=Util::formataTexto($model->getAttributeLabel('principio_ativo'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->getPrincipioAtivo())?>     
					</div>  
				</div>
           	</div>
            <div class="row">
                <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('dados_produto'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->dados_produto)?>    
					</div>
               	</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<?=Util::formataTexto($model->getAttributeLabel('preco_liquido'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->preco_liquido)?>      
					</div>
				</div>
				<div class="col-md-4">
					<?=Util::formataTexto($model->getAttributeLabel('preco_bruto'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->preco_bruto)?>                 	
					</div>
				</div>
				<div class="col-md-4">
					<?=Util::formataTexto($model->getAttributeLabel('diluicao'));?></dt>
					<div class="grid-container">
						<?=Util::formataTexto($model->diluicao)?>         
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?=Util::formataTexto($model->getAttributeLabel('foto'));?></dt>
					<div class="grid-container">
						<img src="<?php echo Yii::app()->createAbsoluteUrl('thumbnail/fill/250/Produto/'.$model->foto);?>"/>  
				</div>
			</div>
			<div class="col-md-6">
				<?=Util::formataTexto($model->getAttributeLabel('baixar_pdf'));?></dt>
				<div class="grid-container">
					<a style="margin-top:10px;" target="_blank" class="btn-link" href="<?php echo Yii::app()->request->baseUrl; ?>/uploads/Produto/<?=$model->baixar_pdf;?>" ><?=$model->baixar_pdf;?></a>            
				</div>
			</div>
                
                    
           
           
           
           <div class="row">
              <div class="col-md-12">
              	  <?php echo $form->labelEx($model,'habilitar'); ?>                  <div class="grid-container">
                  	<?=Util::formataTexto($model->habilitar == 1 ? 'Sim' : 'Não' );?>	
                  </div>
               </div>
          </div>
		  </div>
         
         
         
         	<?php /*        
        	<?
            if(Yii::app()->user->obj->perfil->temPermissaoAction('historicovendas','index')){
                ?>
                <div class="row">
              		<div class="col-md-12">
			    	<?php echo GxHtml::encode($model->getRelationLabel('historicoVendases')); ?></dt>
                    <div class="grid-container">
                    <?php
                    if(count($model->historicoVendases) > 0){
                                echo GxHtml::openTag('ul');
                        foreach($model->historicoVendases as $relatedModel) {
                            echo GxHtml::openTag('li');
                            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('historicoVendas/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
                            echo GxHtml::closeTag('li');
                        }
                        echo GxHtml::closeTag('ul');
                    }
                    else{
                        echo '<i>Nenhum registro encontrado</i>';
                    }
                    ?>
                    </div>
               	</div>
           </div>
        		<?
            }
        	?>                
        	*/?>	       
                 
            
            <?
            if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'update')){
                ?>                <br>
                <div class="clearfix"></div>
                    <a class="btn btn-success pull-right"  href="<?php echo $this->createUrlRel('update',array('id'=>$model->getPrimaryKey()));?>"><i class="fa fa-pencil"></i> Editar</a>
                <div class="clearfix"></div>
                <?
            }
            ?>       
			 	</div>
        </div>
	</div>
</div>
