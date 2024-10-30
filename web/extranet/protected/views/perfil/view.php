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

?>
<div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> Visualizar <?=Util::formataTexto($model->label(1));?>
          <?
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
          
          <div class="row">
              <div class="col-md-12">
              	  <?php echo $form->labelEx($model,'nome'); ?>
                  <div class="grid-container">
                  	<?=Util::formataTexto($model->nome);?>	
                  </div>
               </div>
           </div>
           
           <div class="row">
              <div class="col-md-12">
              	  <?php echo $form->labelEx($model,'permissao'); ?>
                  <div class="grid-container">
                  	<table class="table" style="width:300px;">
						<?
						$controllers = Yii::app()->metadata->getControllers();
                        foreach($model->permissao as $modulo => $operacoes){
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
                                <td>
                                   <strong> <?=Util::formataTexto($label);?></strong>
                                </td>
                                <td>
                                <?
                                foreach($operacoes as $operacao){
                                    ?>
                                    <?=$model->traduzAcao($operacao)?><br/>
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
           </div>
           
           
           <div class="row">
              <div class="col-md-12">
              	  <?php echo $form->labelEx($model,'habilitar'); ?>
                  <div class="grid-container">
                  	<?=Util::formataTexto($model->habilitar == 1 ? 'Sim' : 'Não' );?>	
                  </div>
               </div>
           </div>
           
         </div> 
            
            <?
            if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'update')){
                ?>
                <br>
                <div class="clearfix"></div>
                    <a class="btn btn-success pull-right"  href="<?php echo $this->createUrlRel('update',array('id'=>$model->idperfil));?>"><i class="fa fa-pencil"></i> Editar</a>
                <div class="clearfix"></div>
                <?
            }
            ?>
        
        </div>
	</div>
</div>