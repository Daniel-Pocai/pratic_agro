<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'usuario-form',
        'enableAjaxValidation' => false,
        'htmlOptions'=> array (
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
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
     
    <?
    if(Yii::app()->user->obj->perfil->temPermissaoAction('usuario','create')){
        ?>           
        <div class="form-group">
          <?php echo $form->labelEx($model,'idperfil'); ?>
          <?php echo $form->dropDownList($model, 'idperfil', GxHtml::listDataEx(Perfil::model()->findAll(array('order'=>'nome'))), array('class' => 'form-control','empty'=>'Selecione...')); ?>
        </div>
        <?
    }
    ?>
            
    <div class="form-group">
      <?php echo $form->labelEx($model,'email'); ?>
      <?php echo $form->textField($model, 'email', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
            
    <!-- row -->
                
    <div class="form-group">
      <?php echo $form->labelEx($model,'senha'); ?>
      <?php echo $form->passwordField($model, 'senha', array('maxlength' => 100,'class' => 'form-control','value'=>'','autocomplete'=>'off')); ?>
    </div>
            
            
    <div class="form-group">
      <?php echo $form->labelEx($model,'senha_confirma'); ?>
      <?php echo $form->passwordField($model, 'senha_confirma', array('maxlength' => 100,'class' => 'form-control','value'=>'','autocomplete'=>'off')); ?>
    </div>
    <!-- row -->  
    
    <?
    if(Yii::app()->user->obj->perfil->temPermissaoAction('usuario','status')){
		?>
		<div class="form-group">
		  <?php echo $form->labelEx($model,'habilitar'); ?>
          <div class="clear"></div>
           <label class="cr-styled">
			   <?php echo $form->checkBox($model, 'habilitar'); ?>
               <i class="fa"></i>
       	   </label>   
		</div><!-- row -->
		<?
	}
	?>
    
    <br>
    <div class="clearfix"></div>
    	<button class="btn pull-right btn-success" type="submit"><?=Util::formataTexto("Salvar");?></button>
    <div class="clearfix"></div>
    
    <? 
	$this->endWidget(); 
	?></div><!-- form -->