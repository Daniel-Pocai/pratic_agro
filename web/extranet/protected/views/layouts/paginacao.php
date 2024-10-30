
<div class="row">
    <div class="col-xs-3">
        <?
        if($pagination->itemCount > 0){
			?>
			<div class="muted" style="margin-top:20px;">&nbsp;
			<?
			if($pagination->itemCount == 1){
				?>
				<?=$pagination->itemCount?> registro encontrado
				<?
			}
			else{
				?>
				<?=$pagination->itemCount?> registros encontrados
				<?
			}
			?>
            </div>
			<?
		}
		?>
    </div>
    <div class="col-xs-6 text-center">
      <?
      $this->widget('CLinkPager', array(
		  'pages'=>$pagination,
		  'hiddenPageCssClass'=> 'disabled',
		  'firstPageLabel' => '&laquo;',
		  'prevPageLabel' => '&lsaquo;',
		  'nextPageLabel'=>'&rsaquo;',
		  'lastPageLabel'=>'&raquo;',
		  'selectedPageCssClass' => 'active',
		  'maxButtonCount'=>6,
		  'header'=>'',
		  'htmlOptions'=>array('class'=>'pagination center'),
	  ));
	  ?>
    </div>
    <div class="col-xs-3">
    	
        <div class="btn-group dropdown pull-right" style="margin-top:20px;">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Registros por página: <?=Yii::app()->user->pageSize?>&nbsp;&nbsp;<i class="caret"></i></button>
              <ul class="dropdown-menu" role="menu">
              	<?
				$array_num_paginas = array(5,10,25,50,100);
				foreach($array_num_paginas as $num_paginas){
					?>
					<li <?=$num_paginas == Yii::app()->user->pageSize ? 'class="disabled"' : '' ; ?> ><a href="<?=$this->createUrlRel("index", array_merge($_GET,array('n_reg'=> $num_paginas)));?>">Mostrar <?=$num_paginas;?></a></li>
					<?
				}
				?>
              </ul>          
        </div>
          
    </div>
</div>

<?php /*?><div class="pagination pagination-centered ">
  <div class="pull-left">
		<?
        if($pagination->itemCount > 0){
			?>
			<div class="muted">&nbsp;
			<?
			if($pagination->itemCount == 1){
				?>
				<?=$pagination->itemCount?> registro encontrado
				<?
			}
			else{
				?>
				<?=$pagination->itemCount?> registros encontrados
				<?
			}
			?>
            </div>
			<?
		}
		?>
  </div>
  <?
  $this->widget('CLinkPager', array(
	  'pages'=>$pagination,
	  'hiddenPageCssClass'=> 'active',
	  'firstPageLabel' => '&laquo;',
	  'prevPageLabel' => '&lsaquo;',
	  'nextPageLabel'=>'&rsaquo;',
	  'lastPageLabel'=>'&raquo;',
	  'selectedPageCssClass' => 'active',
	  'header'=>'',
	  'htmlOptions'=>array('class'=>''),
  ));
  ?>
  <div class="pull-right">
    <div class="input-prepend input-append">
        <span class="add-on">Registros por p&aacute;g.:</span>
        <select name="menu_paginacao" onChange="location.href=this.options[this.selectedIndex].value" style="width:32%;">
        	<?
            $array_num_paginas = array(5,10,25,50,100);
			foreach($array_num_paginas as $num_paginas){
				?>
				<option value="<?=$this->createUrlRel("index", array_merge($_GET,array('n_reg'=> $num_paginas)));?>" <? if (Yii::app()->user->pageSize == $num_paginas) echo ' selected="selected"'; ?>><?=$num_paginas;?></option>
				<?
			}
			?>
        </select>
      </div>
  </div>
</div><?php */?>
