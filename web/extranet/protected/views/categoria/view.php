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
					<div class="col-md-10">
                        <?=Util::formataTexto($model->getAttributeLabel('nome'));?></dt>
                        <div class="grid-container">
                            <?=Util::formataTexto($model->nome)?>       
                        </div>
               	    </div>
           		</div>
           
            <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('descricao'));?></dt>
                    <div class="grid-container">
				  		<?=Util::formataTexto($model->descricao)?>     
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
            if(Yii::app()->user->obj->perfil->temPermissaoAction('produto','index')){
                ?>
                <div class="row">
              		<div class="col-md-12">
			    	<?php echo GxHtml::encode($model->getRelationLabel('produtos')); ?></dt>
                    <div class="grid-container">
                    <?php
                    if(count($model->produtos) > 0){
                                echo GxHtml::openTag('ul');
                        foreach($model->produtos as $relatedModel) {
                            echo GxHtml::openTag('li');
                            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('produto/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
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
</div>
