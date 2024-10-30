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
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('data_venda'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->data_venda)?>                 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('idcliente'));?></dt>
                    <div class="grid-container">
				  		<?=($model->cliente !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->cliente)), array('cliente/view', 'id' => GxActiveRecord::extractPkValue($model->cliente, true)),array('class' => 'relational-link')) : null)?>                 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('idproduto'));?></dt>
                    <div class="grid-container">
				  		<?=($model->produto !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->produto)), array('produto/view', 'id' => GxActiveRecord::extractPkValue($model->produto, true)),array('class' => 'relational-link')) : null)?>                 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('quantidade'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->quantidade)?>                 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('valor_unitario'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->valor_unitario)?>                 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('valor_total'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->valor_total)?>                 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('idrepresentante'));?></dt>
                    <div class="grid-container">
				  		<?=($model->representante !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->representante)), array('representante/view', 'id' => GxActiveRecord::extractPkValue($model->representante, true)),array('class' => 'relational-link')) : null)?>                 	</div>
               	  </div>
           		</div>
                    
           
           
           
           <div class="row">
              <div class="col-md-12">
              	  <?php echo $form->labelEx($model,'habilitar'); ?>                  <div class="grid-container">
                  	<?=Util::formataTexto($model->habilitar == 1 ? 'Sim' : 'Não' );?>	
                  </div>
               </div>
          </div>
         
         
         
         
         		        
        		        
        		        
                 
            
            <?
            if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'update')){
                ?>                <br>
                <div class="clearfix"></div>
                    <a class="btn btn-success pull-right"  href="<?php echo $this->createUrlRel('update',array('id'=>$model->getPrimaryKey()));?>"><i class="fa fa-pencil"></i> Editar</a>
                <div class="clearfix"></div>
                <?
            }
            ?>        	</div>
        </div>
	</div>
</div>
