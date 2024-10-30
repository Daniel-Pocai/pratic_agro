$(function () {

  var $image = $('.crop-modal-img');
  var $cropConfig;
  var cropBoxData;
  var canvasData;
  var cropWidth;
  var cropHeight;
  var imgSource;



  $('.crop-config').on('click', function () {

	  var img_param = $(this).attr('src').split("?");

	  var img_split = img_param[0].split("/");

	  var file = img_split[img_split.length-1];
	  var dir = img_split[img_split.length-2];

	  var dimensions_split = img_split[img_split.length-3].split("x");

	  cropWidth = parseFloat(dimensions_split[0]);
	  cropHeight = parseFloat(dimensions_split[1]);

	  imgSource = baseUrl+'/uploads/'+dir+'/'+file;

      if(dir=='gallery'){
           imgSource = baseUrl+'/'+dir+'/'+file;
      }

	  $cropConfig = $(this);

	  $('.crop-modal').modal('show');

	  return false;
  });


  $('.crop-modal-save').on('click', function () {
	  
	  var base64 = $image.cropper('getCroppedCanvas',{
	      width: cropWidth
	  }).toDataURL();

	  $.ajaxNocache({
			url: baseUrl+'/thumbnail/salvar',
			dataType: "json",
			type : 'POST',
			data : {
				base64 : base64,
				width : cropWidth,
				height : cropHeight,
				img_source : imgSource
			},
			beforeSend : function(){
				$('.crop-modal').find('.fa-save').hide();
				$('.crop-modal').find('.fa-loading').show();
				$('.crop-modal-save').attr('disabled','disabled');
			},
			error : function(){
				alert("Não foi possível salvar a imagem");
			},
			success:function (data) {
				if(data.status){
					$('.crop-modal').modal('hide');

					$cropConfig.attr('src',$cropConfig.attr('src')+'?v='+Date.now());
				}
				else{
					alert(data.msg);
				}
			},
			complete : function (data) {
				$('.crop-modal').find('.fa-loading').hide();
				$('.crop-modal').find('.fa-save').show();
				$('.crop-modal-save').removeAttr('disabled');
			}
	  });
  	  return false;
  });


  $('.crop-modal').on('shown.bs.modal', function () {

	 var aspectRatio = cropWidth/cropHeight;

        $image.cropper({
        	aspectRatio: aspectRatio,
        	autoCrop : true,
            dragCrop: true,
            mouseWheelZoom: true,
            resizable: true,
            cropBoxResizable: true
        });

        $image.cropper('replace',imgSource);

        $image.show();

  }).on('hidden.bs.modal', function () {
	   $image.hide();
        $image.cropper('destroy');
  });
});
