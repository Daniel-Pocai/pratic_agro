<div class="form">
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'perfil-form',
        'enableAjaxValidation' => false,
        'htmlOptions'=> array (
            'class' => '',
            'enctype' => 'multipart/form-data',
        )
    ));
    
    $this->renderPartial("//layouts/erros",array(
        'model' => $model,
    ));
    ?>

	
    <div class="form-group">
       <?php echo $form->labelEx($model,'nome'); ?>
       <?php echo $form->textField($model, 'nome', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    
    <div class="form-group">
      <?php echo $form->labelEx($model,'permissao'); ?>
      <div >
          <table class="table">
		   <?
            $controllers = Yii::app()->metadata->getControllers(); #You can specify module name as parameter
            foreach($controllers as $controller_class){
                if($controller_class == 'SiteController' || $controller_class == 'Api2Controller' || $controller_class == 'ApiNewsController' || $controller_class == 'ApiController' || $controller_class == 'ApiDevController' || $controller_class == 'ApiDebugController')
                    continue;

                $class = str_replace("Controller","",$controller_class);
                $route = strtolower($class);
                try {
                    if(!is_file(Yii::app()->basePath.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$class.".php")) {
                        throw new Exception("Unable to load class: $class");
                    }
                    $model_permissao = new $class();
                    $label = $model_permissao->label(2);
                } catch (Exception $e) {
                    $label = $class;
                }
                ?>
                <tr>
                    <td align="left" style="width:200px;">
                        <label class="cr-styled"><input class="permissoes-modulo" name="modulo[]" type="checkbox" id="modulo-area" value="area" <? if ($model->temPermissaoController($route)) echo 'checked="checked"'; ?>> <i class="fa"></i> <?=$label?></label> 
                    </td>
                    <td>
                    <?
                    $controller = $controller_class;
                    $actions = Yii::app()->metadata->getActions($controller_class);
                    foreach($actions as $action){
                        $action_salvar = strtolower($action);
                        ?>
                        <div <?=($model->temPermissaoController($route) ? '' : ' style="display:none;"' );?>  class="permissoes-modulo-operacoes">
                            <div style="clear:both; margin-bottom:10px;	">
                                <label class="cr-styled" style="text-align:left;" for="opercacao-<?=$controller?>-<?=$action;?>"><input class="permissoes-modulo-operacao" name="Perfil[permissao][<?=$route?>][]" type="checkbox" id="opercacao-<?=$controller?>-<?=$action;?>" value="<?=$action_salvar;?>" <? if ($model->temPermissaoAction($route,$action_salvar)) echo 'checked="checked"'; ?> > <i class="fa"></i> <?=$model->traduzAcao($action);?></label>
                            </div>	
                        </div>
                        <?
                    }
                    ?>
                    </td>
                </tr>
                <?
            } 
		    ?>
          </table>
      </div>
    </div>
    
    <?
    if(Yii::app()->user->obj->perfil->temPermissaoAction('perfil','status')){
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
    
    <?php /*?>
	<div class="form-actions">
      <button type="submit" class="btn btn-primary"><?=Util::formataTexto($buttonLabel);?></button>
       <a class="btn" href="javascript: history.go(-1);">Voltar</a>
    </div><?php */?>
    
    <?
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/perfil_form.js?v='.time(), 2);
	?>
    
    <br>
    <div class="clearfix"></div>
    	<button class="btn pull-right btn-success"  type="submit"><?=Util::formataTexto("Salvar");?></button>
    <div class="clearfix"></div>
    <? 
	$this->endWidget(); 
	?>
</div><!-- form -->