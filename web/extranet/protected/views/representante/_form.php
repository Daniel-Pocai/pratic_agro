<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'representante-form',
        'enableAjaxValidation' => false,
        'htmlOptions'=> array (
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
			'action' => $this->createUrlRel($this->action->id),
        )
    ));
    ?> 
	<? 
    $this->renderPartial("//layouts/erros",array(
        'model' => $model,
    ));
    ?>
        
        	    	    	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'nome'); ?>
        <?php echo $form->textField($model, 'nome', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'foto'); ?>
        <?php $this->widget('application.extensions.PluploadImagem.PluploadImagem', array(
			'model' => $model,
			'attribute' => 'foto',
			//'return_size' => 250 //default = 200;
		  )); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">    
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'telefone'); ?>
                <?php echo $form->textField($model, 'telefone',array('rows'=>'10','class'=>'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model, 'email',array('rows'=>'10','class'=>'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'regiao_atuacao'); ?>
                <?php echo $form->dropDownList($model, 'regiao_atuacao',$model->getRegiaoAtuacaoArray(), array('class' => 'form-control','empty'=>'Selecione...')); ?>
            </div>
        </div>
    </div>
    <!-- row -->
            
        
    
	<?
	if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status')){
		?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'habilitar'); ?>
			<div class="clear"></div>
			<label class="cr-styled">
				<?php echo $form->checkBox($model, 'habilitar'); ?> <i class="fa"></i>
			</label>   
		</div>
        <!-- row -->
		
		<?
	}
	?>
    	
    
    <br>
    <div class="clearfix"></div>
    	<button class="btn pull-right btn-success"  type="submit"><?=Util::formataTexto("Salvar");?></button>
    <div class="clearfix"></div>
    
    <? 
	$this->endWidget(); 
	?>
	
</div>
<!-- form -->