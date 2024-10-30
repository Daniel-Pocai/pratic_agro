<?
$this->breadcrumbs[] = 'Erro ';
?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header">
       <h2><i class="icon-ban-circle"></i><span class="break"></span>Erro <?php echo $code; ?></h2>
    </div>
    <div class="box-content">
          <div class="alert alert-error" style="text-align:center;"><h1><?=Util::formataTexto($message);?></h1></div>
    </div>
  </div>
  <!--/span--> 
</div>