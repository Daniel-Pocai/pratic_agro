<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contato</title>
<style type="text/css">
<!--
body, td, th { font-family: Arial, Helvetica, sans-serif; color: #353434; font-size:12px; }
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #d2d2d2;
}
-->
</style>
</head>
<body>
<div style="width:100%;">
  <div style="width:650px; margin-left:auto; margin-right:auto;background-color:#ffffff;">
    <div id="topo"></div>
    <h2 style="color: #252567; font-size:16px;margin-left:20px;">Contato:</h2>
    <div style="padding-left:20px; padding-right:20px;">
      <div style="margin-top:20px;">
      	<table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
            <td width="30%"><strong>Distribuidor:</strong></td>
            <td width="80%"><?=Util::formataTexto($fale_conosco->distribuidor->razao_social);?></td>
          </tr>   
          <tr>
            <td width="30%"><strong>Nome:</strong></td>
            <td width="80%"><?=Util::formataTexto($fale_conosco->nome);?></td>
          </tr>               
          <tr>
            <td width="30%"><strong>E-mail:</strong></td>
            <td width="80%"><?=Util::formataTexto($fale_conosco->email);?></td>
          </tr>
          <tr>
            <td width="30%"><strong>Telefone:</strong></td>
            <td width="80%"><?=Util::formataTexto($fale_conosco->telefone);?></td>
          </tr>
          <tr>
            <td colspan="2">
            	<strong>Mensagem</strong>
            </td>
          </tr>
          <tr>
            <td colspan="2">
            	<?=Util::formataTexto($fale_conosco->mensagem);?>
            </td>
          </tr>
        </table>
      	<br />
      </div>
      <div style="float:right; margin-top:20px;"></div>
    </div>
    <div style="clear:both; height:1px; overflow:hidden">
    </div>
    <div style="margin-top:10px;"></div>
  </div>
</div>
</body>
</html>
