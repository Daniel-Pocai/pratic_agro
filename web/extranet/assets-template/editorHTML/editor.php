
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Default Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">  

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,800' rel='stylesheet' type='text/css'>
    <link href="assets/default/content.css" rel="stylesheet" type="text/css" />

    <link href="scripts/rangeslider.css" rel="stylesheet" type="text/css" />
    <link href="scripts/contentbuilder.css" rel="stylesheet" type="text/css" />
</head>
<body>

<? // conteudo oculto usado para download / export ?>
<div id="newsletter-preloaded-download">
  <form id="export-form" action="export.php" method="post" name="export-form">
    <textarea id="export-textarea" name="export-textarea"></textarea>
  </form>
</div>
<div id="newsletter-preloaded-export"></div>

<? // Caixa que exporta html ?>
<div class="sim-edit" id="sim-edit-export">
  <div class="sim-edit-box" style="height:390px;">
    <div class="sim-edit-box-title">Export Template</div>
    <div class="sim-edit-box-content">
      <div class="sim-edit-box-content-text">Select and copy the entire text below</div>
      <div class="sim-edit-box-content-field">
        <textarea class="sim-edit-box-content-field-textarea text"></textarea>
      </div>
    </div>
    <div class="sim-edit-box-buttons">
      <div class="sim-edit-box-buttons-cancel" style="margin-left:0px;">Cancel</div>
    </div>
  </div>
</div>

<? // botoes ?>
<div id="newsletter-builder-sidebar-buttons-bbutton">Export</div>
<div id="newsletter-builder-sidebar-buttons-abutton">Download Template</div>


<div id="contentarea" class="container">

    <!-- This is just a sample content -->
    
    
    

</div>


<script src="scripts/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui.min.js" type="text/javascript"></script>
<script src="scripts/rangeslider.min.js" type="text/javascript"></script>
<script src="scripts/contentbuilder.js" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $("#contentarea").contentbuilder({
            zoom: 0.85, 
            snippetOpen: true,
            snippetFile: 'assets/default/snippets.html'
        });

    });

    function view() {
        var sHTML = $('#contentarea').data('contentbuilder').viewHtml();
        //alert(sHTML);
    }
</script>



</body>
</html>
