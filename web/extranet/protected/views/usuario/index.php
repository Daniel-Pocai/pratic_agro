<?php
$this->breadcrumbs[$model->label(2)] = array('index');
if($this->hasRel()){
	$this->breadcrumbs[$model->label(2)] = array('rel'=>$this->getRel());
}
?>
<div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> <?=Util::formataTexto($model->label(2));?>
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
	<div class="col-md-3 col-sm-12">
        <div class="panel-body p-0">
            <div class="list-group no-border mail-list">
            	<a href="<?=$this->createUrl('index');?>" class="list-group-item <?=!is_numeric($_GET['idperfil']) ? 'active' : '' ;?>">Todos <b>(<?=Usuario::model()->count();?>)</b></a>
				<?
                $criteria_perfis = new CDbCriteria();
				$criteria_perfis->order = 'nome';
				$perfis = Perfil::model()->findAll($criteria_perfis);
				foreach($perfis as $perfil){
					?>
					<a href="<?=$this->createUrl('index',array('idperfil'=>$perfil->idperfil));?>" class="list-group-item <?=$_GET['idperfil'] == $perfil->idperfil ? 'active' : '' ;?>"><?=Util::formataTexto($perfil->nome);?> <b>(<?=count($perfil->usuarios);?>)</b></a>
					<?
				}
				?>
            </div>
        </div>
    </div>
   <div class="col-md-9 col-sm-12">
		<div class="panel panel-default">
		<? 
        $this->renderPartial("_search",array(
            'model' => $model,
        ));
        if(count($dataProvider->data) > 0){
            ?>
            <table class="table table-hover table-registros">
                <thead>
                    <tr>
                        <th style="width:60px;">
                            <label class="cr-styled cr-acoes">
                              <input name="select-all" class="select-all" value="select-all" type="checkbox"><i class="fa"></i>
                          </label>
                        </th>
                        <?
                        foreach($this->getRepresentingFields() as $field){
                            $icon = "fa-sort";
                            $ordem = "asc";
                            if($_GET['f'] == $field){
                                if($_GET['o'] == "asc"){
                                    $ordem = "desc";
                                    $icon = " fa-sort-desc";
                                }
                                elseif($_GET['o'] == "desc"){
                                    $ordem = "asc";
                                    $icon = " fa-sort-asc";
                                }
                            }
                            ?>
                            <th>
                                <a href="<?php echo $this->createUrlRel('index',array_merge($_GET,array('f'=>$field,'o'=>$ordem)));?>">
                                    <?=Util::formataTexto($model->getAttributeLabel($field));?> 
                                    <i class="fa <?=$icon;?>"></i> 
                                </a>
                            </th>
                            <?
                        }
                        ?>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach($dataProvider->data as $data){
                        $this->renderPartial('_view',array('data'=>$data));
                    }
                    ?>
                </tbody>
            </table>
            <hr>
            <? 
            $this->renderPartial("//layouts/paginacao",array(
                'pagination' => $dataProvider->pagination,
            ));
        }
        else{
        	?>
			<p class="alert alert-warning">Nenhum registro encontrado</p>
			<?
		       
        }
        ?>
        </div> <!-- panel -->
    </div> 
</div>