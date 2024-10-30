<?
$autorizacao_delete = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'delete');
$autorizacao_view = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'view');
$autorizacao_update = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'update');
$autorizacao_status = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status');
?>
<tr data-id="<?=$data->getPrimaryKey()?>">
  <td><?= Util::formataTexto($data->data);?></td>
  <td><?= Util::formataTexto($data->usuario_nome);?></td>
  <td><?= Dicionario::modulo($data->controller);?></td>
  <td><?= Dicionario::acao($data->action);?></td>
  <td><?= Util::formataTexto($data->registro_nome);?></td> 
  <td class="text-right td-operacoes">
	<?
    if($autorizacao_view){
       ?>
       <a class="btn btn btn-default btn-show hidden-lg btn-sm" href="<?php echo $this->createUrlRel('view',array('id'=>$data->getPrimaryKey()));?>"><i class="fa fa-search"></i> Ver detalhes</a>
       <? 
    }
    ?>  </td>
</tr>