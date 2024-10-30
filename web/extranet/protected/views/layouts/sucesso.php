<?
if($success != ""){
	?>
	<div class="alert alert-success" style="max-width:500px;" >
		<button type="button" class="close" data-dismiss="alert">×</button>
		<?
        if($success == 'create'){
			?>
			Cadastro realizado com sucesso, confirma:<br/>
            <a href="<?=$this->createUrlRel('create');?>" class="btn"><i class="icon-plus"></i> Novo cadastro</a>
			<?
		}
		else{
			?>
			Cadastro atualizado com sucesso, confirma:
			<?
		}
		?>
	</div>
	<?
}
?>
