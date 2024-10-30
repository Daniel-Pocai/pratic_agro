<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'cliente-form',
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
    
    <!-- row -->

    <div class="form-group">    
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'idrepresentante'); ?>
                <?php echo $form->dropDownList($model, 'idrepresentante', GxHtml::listDataEx(Representante::model()->findAllAttributes(null, true)), array('class' => 'form-control','empty'=>'Selecione...')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'nome'); ?>
                <?php echo $form->textField($model, 'nome', array('maxlength' => 100,'class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'cpf_cnpj'); ?>
                <?php echo $form->textField($model, 'cpf_cnpj', array('maxlength' => 100,'class' => 'form-control')); ?>
            </div>
        </div>
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
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model, 'email', array('maxlength' => 100,'class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'telefone'); ?>
                <?php echo $form->textField($model, 'telefone', array('maxlength' => 100,'class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'celular'); ?>
                <?php echo $form->textField($model, 'celular', array('maxlength' => 100,'class' => 'form-control')); ?>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'cep'); ?>
                <?php echo $form->textField($model, 'cep', array('maxlength' => 100,'class' => 'form-control')); ?>
            </div>
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'idestado'); ?>
                <?php echo $form->dropDownList($model, 'idestado', GxHtml::listDataEx(Estado::model()->findAllAttributes(array('idestado', 'nome'), true)), array('class' => 'form-control', 'empty' => 'Selecione...')); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
		<?php echo $form->labelEx($model,'endereco_completo'); ?>
        <?php echo $form->textArea($model, 'endereco_completo',array('rows'=>'10','class'=>'form-control')); ?>
    </div>
    <!-- row -->
        	      
            
        

    
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