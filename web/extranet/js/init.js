// JavaScript Document

//Utilizado pelo controle das mensagem de sucesso, guarda a quantidade de registros pendentes para mostrar as mensagens de sucesso
var qtd_selecionados;

//Seleção de checkbox através do clique na tabela
$(document).on('click', '.table-registros > tbody > tr', function (e) {

	//console.log(e.target.nodeName);
	///alert(e.target.nodeName);
	if(e.target.nodeName == 'TD'){
		$(this).find('.operacao-id').attr('checked',!$(this).find('.operacao-id').attr('checked')).trigger('change');
	}
});



$(".table-registros").on( "mouseenter", "tr", function() {
  	$(this).find('.btn-show').removeClass('hidden-lg');
});

$(".table-registros").on( "mouseleave", "tr", function() {
	$(this).find('.btn-show').addClass('hidden-lg');
});


//Seleção de registros
$( ".table-registros" ).on("change", ".select-all", function() {

	 if($(this).is(':checked')){
		 $('.operacao-id').attr('checked','checked');
	 }
	 else{
		$('.operacao-id').removeAttr('checked','checked');
	 }

	 $('.operacao-id').trigger('change');

	 var total = $(".operacao-id:checked").length;
	 if(total>0){
		  $(".menu-superior-table").show();
	 }
	 else{
		  $(".menu-superior-table").hide();
	 }
});


$( ".table-registros" ).on("change", ".operacao-id", function() {
  	 if($(this).is(':checked')){
		 $(this).parents('tr').addClass('active');
	 }
	 else{
		 $(this).parents('tr').removeClass('active');
	 }

	 var total = $(".operacao-id:checked").length;
	 if(total>0){
		$(".menu-superior-table").show();
	 }
	 else{
		 $(".menu-superior-table").hide();
	 }

	 if(total == $(".operacao-id").length){
		 $('.select-all').attr('checked','checked');
	 }
	 else{
		 $('.select-all').removeAttr('checked');
	 }

});

//Ajax padrão, no-cache
function getNoCache(){
	var nocache = new Date();
	return nocache.getTime()/Math.random();
}

$.ajaxNocache = function(arguments) {

	var src = arguments.url;
	if(src.indexOf("?") == -1)
	   src=src+"?";
	else
	   src=src+"&";

	src = src+'ajax_nocache='+getNoCache();

	arguments.url = src;

	arguments.error = function(){
		 alert('Não foi possível confirmar a operação, tente novamente');
	};

	$.ajax(arguments);

}

//Alteração de status
function alterarStatus(elem,habilitar){

	var time = new Date().getTime();
	var src = $(elem).attr('data-base-url');

	if(src.indexOf("?") == -1)
   	   src=src+"?";
	else
	   src=src+"&";

	$.ajax({
		url: src+'habilitar='+habilitar+'&ajax_nocache='+time,
		dataType: "json",
		beforeSend: function (xhr) {
			$(elem).addClass('clicado')
			$(elem).html('<i class="fa fa-cog fa-spin"></i>');
			$(elem).attr('disabled','disabled');
		},
		error:function(xhr, ajaxOptions, thrownError) {
			alert("Erro ao executar a operação. Contate o suporte");
		},
		success:function (data) {
			if(data.status){

				qtd_selecionados--;

				if(data.habilitar == 1){
					$(elem).html('<i class="fa fa-check ativo"></i>');
					$(elem).addClass('desativar');
					$(elem).removeClass('ativar');
					$(elem).attr('href',$(elem).attr('href').replace('habilitar=1','habilitar=0'));
				}
				else{
					$(elem).html('<i class="fa fa-ban inativo"></i>');
					$(elem).addClass('ativar');
					$(elem).removeClass('desativar');
					$(elem).attr('href',$(elem).attr('href').replace('habilitar=0','habilitar=1'));
				}
				$(elem).removeAttr('disabled');
				$(elem).removeClass('clicado');

				if(qtd_selecionados == 0)
					$.Notification.autoHideNotify('success','top center', 'Operação finalizada', 'Confira os dados abaixo.');

			}
			else{
				alert("Erro ao executar a operação. Contate o suporte");
			}
		},
	});

};

$(".menu-superior-table").on( "click", ".operacao-em-massa-habilitar", function() {

	qtd_selecionados = $('.operacao-id:checked').length;

	$('.operacao-id:checked').each(function(index, element) {
       alterarStatus($(this).parents('tr').find('.btn-status'),1);
	});

	return false;
});


$(".menu-superior-table").on( "click", ".operacao-em-massa-desabilitar", function() {

	qtd_selecionados = $('.operacao-id:checked').length;

	$('.operacao-id:checked').each(function(index, element) {
       alterarStatus($(this).parents('tr').find('.btn-status'),0);
    });


	return false;
});

$(".td-operacoes").on( "click", ".desativar", function() {
	qtd_selecionados = 1;
  	alterarStatus(this,0);
	return false;
});

$( ".td-operacoes" ).on( "mouseenter", ".desativar", function() {
  	if(!$(this).hasClass('clicado')){
		$(this).html('<i class="fa fa-ban inativo"></i>');
	}
});

$( ".td-operacoes" ).on( "mouseleave", ".desativar", function() {
	if(!$(this).hasClass('clicado')){
		$(this).html('<i class="fa fa-check ativo"></i>');
	}
});

$( ".td-operacoes" ).on("click",".ativar", function() {
	qtd_selecionados = 1;
  	alterarStatus(this,1);
	return false;
});

$( ".td-operacoes" ).on("mouseenter", ".ativar", function() {
  	if(!$(this).hasClass('clicado')){
		$(this).html('<i class="fa fa-check ativo"></i>');
	}
});
$( ".td-operacoes" ).on("mouseleave", ".ativar", function() {
  	 if(!$(this).hasClass('clicado')){
		 $(this).html('<i class="fa fa-ban inativo"></i>');
	 }
});


//Exclusão de registro(s)

function excluirRegistro(id){

	var tr = $('tr[data-id="'+id+'"]');
	var opercacoes = $(tr).find('.td-operacoes');

	var href = $(opercacoes).find('.btn-delete').attr('href');
	href += '&confirm=1';

	$(opercacoes).html('<span class="loading-excluindo"><i class="fa fa-cog fa-spin"></i> Excluindo');

	$.ajaxNocache({
		url: href,
		dataType: "json",
		error : function(){
			$(opercacoes).html('<div class="error-text"><i class="fa fa-ban"></i>Não foi possível realizar a exclusão, contate a adminsitração</div>');
		},
		success:function (data) {

			qtd_selecionados--;

			if(data.status){
				$(tr).find('.cr-acoes').remove();
				$(tr).addClass('tr-excluido');
				$(opercacoes).html('<div class="error-text"><i class="fa fa-check"></i> Excluído</div>');
			}
			else{
				$(opercacoes).html('<div class="error-text"><i class="fa fa-ban"></i> '+data.msg+'</div>');
			}

			if(qtd_selecionados == 0)
				$.Notification.autoHideNotify('success','top center', 'Exclusão finalizada', 'Confira os dados abaixo.');
		},
	});
}

$( ".modal-main").on("click", ".excluir-confirmacao", function() {
	$(".modal-main").modal('hide');
	var item_exclusao = this;
	var id = $(item_exclusao).attr('data-id');

	qtd_selecionados = 1;
	excluirRegistro(id)
	return false;
});

$('.modal-main').on( "click", ".operacao-em-massa-excluir-confirmacao", function() {

	$(".modal-main").modal('hide');

	qtd_selecionados = $('.operacao-id:checked').length;
	$('.operacao-id:checked').each(function(index, element) {
		excluirRegistro($(this).val());
    });

	return false;
});

$(".btn-delete").click(function(){

	$('.modal-main').modal('show');

	var time = new Date().getTime();
	$.ajax({
		url: $(this).attr('href')+'&time='+time,
		beforeSend: function ( xhr ) {
			$(".modal-main").find('.modal-title').text('Carregando...');
			$(".modal-main").find('.modal-body').html('<i style="font-size:30px;" class="fa fa-cog fa-spin"></i>');
			$(".modal-main").modal('show');
		},
		error : function(){
			$(".modal-main").find('.modal-content').html('<div class="error-text"><i class="fa fa-ban"></i> Não foi possível realizar a exclusão, contate a adminsitração</div>');
		},
		success:function ( data) {
			$(".modal-main").find('.modal-content').html(data);
		},
	});
	return false;

});


$(".menu-superior-table").on( "click", ".operacao-em-massa-excluir", function() {

	var values = $('.operacao-id:checked').map(
                    function() {
                        return this.value
                  }).get();
	var url = $(this).attr('data-url');

	$.ajaxNocache({
		url: url+'?id='+values,
		beforeSend: function ( xhr ) {
			$(".modal-main").find('.modal-title').text('Carregando...');
			$(".modal-main").find('.modal-body').html('<i style="font-size:30px;" class="fa fa-cog fa-spin"></i>');
			$(".modal-main").modal('show');
		},
		success:function ( data) {
			$(".modal-main").find('.modal-content').html(data);
		},
	});
	return false;
});

$(".form-group").on("change", ".video-tipo", function() {
	if($(this).val() == 'arquivo'){
		$('.video-tipo-incorporar').hide();
		$('.video-tipo-arquivo').show();
	}
	else{
		$('.video-tipo-arquivo').hide();
		$('.video-tipo-incorporar').show();
	}
});

$(".top-head").on("click", ".menu-toggle", function() {
	var valor =$.cookie('menu-modo') == 'retrair' ? 'expandir' : 'retrair';
	$.cookie('menu-modo', valor,{ expires: 365, path: '/' });
});


$(".panel-filtros").on("change",".filtro-controller", function() {
	var href = $(this).attr('data-url');
	var val = $(this).val();

	if(val == '')
		return false;
	$.ajaxNocache({
		url: href+val,
		dataType: "json",
		beforeSend: function(){
			$('.filtro-action').find('option').remove().end().append('<option value="">Carregando ações...</option>').val('');
		},
		error : function(){
			alert('Não foi possível realizar a operação, certifique-se que esteja devidamente autenticado');
		},
		success:function (data) {
			if(data.status){
				$('.filtro-action').find('option').remove().end().append('<option value="">Selecione...</option>').val('');
				$.each(data.actions, function(value, label) {
					console.log(label);
					if(value)
						$('.filtro-action').append('<option value="'+value+'">'+label+'</option>');
				});
			}
			else{
				$('.filtro-action').find('option').remove().end().append('<option value="">Nenhuma ação encontrada</option>').val('');
			}
		},
	});
	return false;
});

$(".requisicao-heading").on("click",".requisicao-btn", function(){
	if($('.requisicao-div').hasClass('hide')){
		$('.requisicao-btn').html('<i class="ion-minus-round"></i>');
		$('.requisicao-div').removeClass('hide');
	}
	else{
		$('.requisicao-btn').html('<i class="ion-plus-round"></i>');
		$('.requisicao-div').addClass('hide');
	}
	return false;
});

function initMask(){
	$('.data').mask('00/00/0000');
	$('.cep').mask('00000-000');
	$('.telefone').mask('(00) 0000-0000?',{
	  translation: {
		'?': {
		  pattern: /[0-9]/, optional: true
		}
	  }
	});
	$('.cpf').mask('000.000.000-00', {reverse: true});
	$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
}

$(document).ready(function($){
	initMask();
    $("#sortable-list").sortable({
        handle: '.handle',
        update: function() {
            var order = $('#sortable-list').sortable('serialize');
			var link_model = $('#sortable-list').data('link');
			var operador="&";
			if(link_model.indexOf("?") == -1)
			   operador="?";
            $("#sortable_info").load(link_model+operador+"page_size="+$("#menu_registros_pagina").val()+"&num_pagina=" + $("#menu_pagina").val() + "&" + order);
        }
    });
});
