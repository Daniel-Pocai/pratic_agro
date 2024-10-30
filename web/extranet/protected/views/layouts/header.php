<?
$baseUrl = Yii::app()->baseUrl; 
?>	
        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link rel="shortcut icon" href="img/favicon.ico">
        <title>Pratic Agro</title>
		<meta name="description" content="Pratic Agro">
		<meta name="author" content="Pratic Agro">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <?
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/bootstrap.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/bootstrap-reset.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/animate.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/font-awesome/css/font-awesome.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/ionicon/css/ionicons.min.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/magnific-popup/magnific-popup.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/jquery-datatables-editable/datatables.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/helper.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/helper-noie.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/sweet-alert/sweet-alert.min.css");
		Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/notifications/notification.css");
		Yii::app()->clientScript->registerCssFile($baseUrl."/css/style.css");
        ?>

<!-- Start of  Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","brsis.zendesk.com");/*]]>*/</script>
<!-- End of  Zendesk Widget script -->