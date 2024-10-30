// JavaScript Document
$(".permissoes-modulo").change(function(){
	$tr_parent = $(this).parents('tr');
	
	if($(this).is(':checked')){
		$tr_parent.find('.permissoes-modulo-operacoes').show();
		$tr_parent.find('.permissoes-modulo-operacao').attr('checked','checked');
		$tr_parent.find('span').addClass('checked');
	}
	else{
		$tr_parent.find('.permissoes-modulo-operacoes').hide();
		$tr_parent.find('.permissoes-modulo-operacao').removeAttr('checked');
		$tr_parent.find('span').removeClass('checked');
	}
});