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
           
		   <div class="form-group">
				<div class="row">
					<div class="col-md-2">
					<?=Util::formataTexto($model->getAttributeLabel('posicao'));?></dt>
                    <div class="grid-container">
						<?=Util::formataTexto($model->posicao)?>      
                    </div>
               	  	</div>
					<div class="col-md-8">
						<?=Util::formataTexto($model->getAttributeLabel('data'));?></dt>
						<div class="grid-container">
							<?=Util::formataTexto($model->data)?>                
					 	</div>
               	  </div>
					<div class="col-md-2">
						<?=Util::formataTexto($model->getAttributeLabel('nova_aba'));?></dt>
						<div class="grid-container">
							<?=Util::formataTexto($model->nova_aba ? 'Sim' : 'Não')?>             
					    </div>
               	  	</div>
				</div>
		   </div>
		   <div class="form-group">
				<div class="row">
		   			<div class="col-md-4">
						<?=Util::formataTexto($model->getAttributeLabel('local'));?></dt>
						<div class="grid-container">
							<?=Util::formataTexto($model->getLocal())?>              
					   	</div>
               	  	</div>
					<div class="col-md-8">
						<?=Util::formataTexto($model->getAttributeLabel('titulo'));?></dt>
						<div class="grid-container">
							<?=Util::formataTexto($model->titulo)?>               
					  	</div>
               	  	</div>
				</div>
		   </div>

		   <div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<?=Util::formataTexto($model->getAttributeLabel('data_entrada'));?></dt>
						<div class="grid-container">
							<?=Util::formataTexto($model->data_entrada)?>             
					    </div>
					</div>
					<div class="col-md-6">
						<?=Util::formataTexto($model->getAttributeLabel('data_saida'));?></dt>
						<div class="grid-container">
							<?=Util::formataTexto($model->data_saida)?>              
					   	</div>
               	  	</div>
				</div>
		   </div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('link'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->link)?>                
					 	</div>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('imagem'));?></dt>
                    <div class="grid-container">
				  		<img src="<?php echo Yii::app()->createAbsoluteUrl('thumbnail/fill/250/Banner/'.$model->imagem);?>"/>          
					       	</div>
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
