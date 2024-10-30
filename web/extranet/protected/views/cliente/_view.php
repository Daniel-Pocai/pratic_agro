<?
$autorizacao_delete = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'delete');
$autorizacao_view = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'view');
$autorizacao_update = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'update');
$autorizacao_status = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status');
?><tr data-id="<?=$data->getPrimaryKey()?>">
  <?
  if($autorizacao_status || $autorizacao_delete){
	  ?>	  <td style="max-width:10px;" class="mail-select hidden-xs">
		  <label class="cr-styled cr-acoes">
			  <input name="id[]" class="operacao-id" data-name="<?=$data->representingName()?>" value="<?=$data->getPrimaryKey()?>" type="checkbox"><i class="fa"></i>
		  </label>
	  </td>
	  <?
  }
  foreach($this->getRepresentingFields() as $field){
  	?>
	<td data-title="<?=$data->getAttributeLabel($field);?>">
    <?php 
    if($field == 'foto'){
        $imageUrl = '/pratic_agro/web/extranet/uploads/Cliente/' . basename($data->foto);
        if(!empty($data->foto)){
            echo '<img src="' . $imageUrl . '"  width="150" alt="Foto" onerror="this.onerror=null; this.src=\'/extranet/uploads/Cliente/default-image.jpg\';" />';
        } else {
            echo '<img src="/extranet/uploads/Cliente/default-image.jpg" alt="Foto não disponível" />';
        }
    } else {
        echo Util::formataTexto($data->$field);
    }
    ?>
    </td>
	<?
  }
  ?>  
  <td class="text-right td-operacoes">
	<?
    if($autorizacao_delete){
       ?>       <a class="btn btn-default btn-delete btn-show hidden-lg" href="<?php echo $this->createUrlRel('delete',array('id'=>$data->getPrimaryKey()));?>"><i class="fa fa-trash-o"></i></a>
       <? 
    }
    if($autorizacao_view){
       ?>       <a class="btn btn btn-default btn-show hidden-lg" href="<?php echo $this->createUrlRel('view',array('id'=>$data->getPrimaryKey()));?>"><i class="fa fa-search"></i></a>
       <? 
    }
    if($autorizacao_update){
        ?>			  
        <a class="btn btn-default" href="<?php echo $this->createUrlRel('update',array('id'=>$data->getPrimaryKey()));?>"><i class="fa fa-pencil"></i></a>
        <?
    }
    if ($data->habilitar=="1"){
        if($autorizacao_status){
            ?>            <a href="<?php echo $this->createUrlRel('status',array('id'=>$data->getPrimaryKey(),'habilitar' => 0));?>" data-base-url="<?php echo $this->createUrlRel('status',array('id'=>$data->getPrimaryKey()));?>" title="Desabilitar Registro" class="btn  btn-default desativar btn-status"><i class="fa fa-check ativo"></i></a><?
        }
        else{
            ?>            <span class="btn-default btn  disabled"><i class="fa fa-check ativo"></i></span>
            <?
        }
    }
    else{
        if($autorizacao_status){
            ?><a href="<?php echo $this->createUrlRel('status',array('id'=>$data->getPrimaryKey(),'habilitar' => 1));?>" data-base-url="<?php echo $this->createUrlRel('status',array('id'=>$data->getPrimaryKey()));?>" title="Habilitar Registro" class="btn  btn-default ativar btn-status"><i class="fa fa-ban inativo"></i></a><?
        }
        else{
            ?>            <span class="btn-default btn  disabled"><i class="fa fa-ban inativo"></i></span>
            <?
        }
    }
    ?>  </td>
</tr>