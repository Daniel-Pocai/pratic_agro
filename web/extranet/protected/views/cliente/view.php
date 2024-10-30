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
				<div class="col-md-4">    
				  	<?=Util::formataTexto($model->getAttributeLabel('idrepresentante'));?></dt>
                    <div class="grid-container">
				  		<?=($model->representante !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->representante)), array('representante/view', 'id' => GxActiveRecord::extractPkValue($model->representante, true)),array('class' => 'relational-link')) : null)?>       
					          	
               	  	</div>
           		</div>
                <div class="col-md-4">
				  	<?=Util::formataTexto($model->getAttributeLabel('nome'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->nome)?>            
			     	</div>
               	</div>
                <div class="col-md-4">
				  	<?=Util::formataTexto($model->getAttributeLabel('cpf_cnpj'));?></dt>
                    <div class="grid-container">
						<?=Util::formataTexto($model->cpf_cnpj)?>
                	</div>
               	</div>
           	</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<?=Util::formataTexto($model->getAttributeLabel('foto'));?></dt>
			<div class="grid-container">
				<img src="<?php echo Yii::app()->createAbsoluteUrl('thumbnail/fill/250/Cliente/'.$model->foto);?>"/>  
			               	</div>
			</div>
        </div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
				  	<?=Util::formataTexto($model->getAttributeLabel('email'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->email)?>  
	               	</div>
               	</div>
				<div class="col-md-4">
				  	<?=Util::formataTexto($model->getAttributeLabel('telefone'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->telefone)?> 
	               	</div>
               	</div>
				<div class="col-md-4">
				  	<?=Util::formataTexto($model->getAttributeLabel('celular'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->celular)?>   
	              	</div>
               	</div>
           	</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<?=Util::formataTexto($model->getAttributeLabel('cep'));?></dt>
			<div class="grid-container">
				<?=Util::formataTexto($model->cep)?>                 	</div>
			</div>
		</div>
										<div class="row">
			<div class="col-md-12">
			<?=Util::formataTexto($model->getAttributeLabel('endereco_completo'));?></dt>
			<div class="grid-container">
				<?=Util::formataTexto($model->endereco_completo)?>                 	</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<?=Util::formataTexto($model->getAttributeLabel('idcidade'));?></dt>
                    <div class="grid-container">
				  		<?=($model->cidade !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->cidade)), array('cidade/view', 'id' => GxActiveRecord::extractPkValue($model->cidade, true)),array('class' => 'relational-link')) : null)?>        
					         	
               	  	</div>
				</div> 
                <div class="col-md-6">
				  	<?=Util::formataTexto($model->getAttributeLabel('idestado'));?></dt>
                    <div class="grid-container">
				  		<?=($model->estado !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->estado)), array('estado/view', 'id' => GxActiveRecord::extractPkValue($model->estado, true)),array('class' => 'relational-link')) : null)?>      
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
            ?>        	</div>
        </div>
	</div>
</div>
