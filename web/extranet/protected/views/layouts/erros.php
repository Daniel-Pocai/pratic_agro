<?
if(count($erros = $model->getErrors()) > 0){
	?>
    <div class="alert alert-danger" style="max-width:500px;margin-top:20px;" >
    	<button type="button" class="close" data-dismiss="alert">×</button>
        <?
        foreach($erros as $erro){
			if(is_array($erro)){
				foreach($erro as $err){
					echo Util::formataTexto($err)."<br/>";
				}
			}
			else
           		echo Util::formataTexto($erro)."<br/>";
        }
        ?>
    </div>
	<?
}