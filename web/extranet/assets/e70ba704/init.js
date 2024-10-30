function ativaUploaderImagem(class_ref,campo,patch){
	if($('#'+campo).length > 0){   
	
		var operador="&";
		if(patch.indexOf("?") == -1)
		   operador="?";	
			
		var uploader = new plupload.Uploader({
			runtimes : 'html5,silverlight,flash',
			required_features: 'chunks',
			url : patch+operador+'class='+class_ref,
			browse_button : campo+'_pickfiles',
			max_file_size : '10mb',
			chunk_size : '1mb',
			multi_selection : false,
			multipart: true,
			flash_swf_url : patch+'/js/plupload.flash.swf',
			silverlight_xap_url : patch+'/js/plupload.silverlight.xap'
		});
		
		var label_upload_btn = '<i class="fa fa-upload"></i> Selecionar arquivo';
		
		uploader.bind('Init', function(up, params) {
			$('#'+campo).prepend(' \
					<a id="'+campo+'_pickfiles" class="btn btn-default btn-upload" style="width:100%;">'+label_upload_btn+'</a><div class="clearfix"></div>\
					<div class="progress" style="margin-top:10px;height:20px;display:none;">\
					  <div class="progress-bar" role="progressbar" style="width: 0%;">\
					  </div>\
					</div>\
			');
			
			
			if(params.runtime == 'silverlight' || params.runtime == 'flash')
				$('#'+campo).after('<div class="pluplpad_obs">Utlizando: ' + params.runtime + '. Para melhorar a velocidade do upload utilize o navegador <a href="https://www.google.com/chrome" target="_blank" >Chrome</a>.<br/> Com o navegador atual o upload pode demorar atÈ 5 vezes mais.</div>');
		});
		
		uploader.bind('FilesAdded', function(up, file) {
			var fileName = file[0].name;
			var fileExt = fileName.split('.').pop();
			
			fileExt = fileExt.toLowerCase();
			
			if(fileExt != 'png' && fileExt != 'jpg'){
				alert('Extens„o inv·lida ('+fileExt+'). Somente arquivos png ou jpg');
				return false;
			}
			
			$('#'+campo).children('.btn-upload').html('<i class="fa fa-cog fa-spin"></i> <span class="plupload-percent">Conectando...</span>');
			setTimeout(function() {
				uploader.start();					
			},400);
		});
		  
		uploader.bind('UploadFile', function(up, file) {
			data = new Date();
			file.name = retiraAcento(file.name);
			file.name = file.name.replace(".","_" + data.getTime() + ".");
			nome_array  = file.name.split('.');
			$('#'+campo).find('input[name="'+class_ref+'['+campo+']"]').val(file.name);
			$('#'+campo).children('.btn-upload').addClass('disabled');
			
			$('#'+campo).children('.progress').children('.progress-bar').css("width","0%");
			$('#'+campo).children('.progress').show();
		});
		
		uploader.bind('UploadProgress', function(up, file) {
			$('#'+campo).find('.plupload-percent').text(file.percent+"%");
			$('#'+campo).children('.progress').children('.progress-bar').css("width",file.percent+"%");
			$('#'+campo).children('.msg_status').find('.status').html(+file.percent+"%");
			
		});
		
		
		uploader.bind('Error', function(up, args) {
            // Called when a error has occured
           alert("OperaÁ„o inv·lida");
        });
		
		uploader.bind('FileUploaded', function(up, file, object){
			
			
			var response = jQuery.parseJSON(object.response);
			
			$('#'+campo).children('.btn-upload').removeClass('disabled');
			$('#'+campo).children('.progress').hide();
			
			$('#'+campo).children('.btn-upload').html(label_upload_btn);
			
			
			if(response.error != undefined && response.error != null && response.error != ""){
				alert(response.error.message);
			}
			else{
				var src = $('#'+campo).find('.img-thumbnail').attr('data-url');
				$('#'+campo).find('.img-thumbnail').attr('src',src+file.name);
			}
			
		
		});
		
		uploader.init();
	}
}

function salvar(elem){
	$('#'+elem).submit();
}

function retiraAcento(text){
	text = text.replace(new RegExp('[¡¿¬√]','gi'), 'A');
	text = text.replace(new RegExp('[…» ]','gi'), 'E');
	text = text.replace(new RegExp('[ÕÃŒ]','gi'), 'I');
	text = text.replace(new RegExp('[”“‘’]','gi'), 'O');
	text = text.replace(new RegExp('[⁄Ÿ€]','gi'), 'U');
	text = text.replace(new RegExp('[«]','gi'), 'C');
	text = text.replace(new RegExp('[ ]','gi'), '_');
	text = text.replace(new RegExp('[^a-zA-Z0-9._]','gi'), '_');	
	text = text.toLowerCase();
	return text;
}

$('.disabled').on('click',function(){return false;});