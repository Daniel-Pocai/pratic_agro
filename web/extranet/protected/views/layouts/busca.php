<div class="span12">
    <div class="pull-left " style="margin-right:30px;">
        <form id="form_busca" name="form_busca" method="get" action="<?php echo Yii::app()->request->baseUrl; ?>/<?=$controller?>"> 
          <?
          /*if (is_array($campos_ocultos_aux)){
              ?>
              <input type="hidden" name="<?=$campos_ocultos_aux[0]?>" value="<?=$campos_ocultos_aux[1]?>" />
              <?
          }*/
          ?>
          <div class="controls">
            <div class="input-append">
              <input size="16" type="text" name="q" value="<?=$_GET['q'];?>" class="span10">
              <button class="btn" type="submit">Busca</button> 
            </div>
          </div>
      </form>
    </div>
<?
//if($_SESSION[usuario_logado]->perfil->temPermissao($modulo,'formulario') && is_array($template_botao_novo)){
	if($button != ""){
		?>
		<div class="pull-right">
			<a href="<?php echo $this->createUrlRel('create');?>" class="btn btn-m "><i class="icon-plus"></i>&nbsp;<?=Util::formataTexto($button)?></a>
		</div>
		<?
	}
//}
?>
</div>
<div class="clearfix"></div>
