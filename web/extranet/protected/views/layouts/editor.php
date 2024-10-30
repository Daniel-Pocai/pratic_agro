<div class="drag-drop-editor-template">
        	<?php echo $form->hiddenField($model, $field, array('id' => 'content-field')); ?>
            <div id="content_editor"><?=$model->$field?></div>

            <?php
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/assets-template/editorHTML/scripts/google-fonts.css");

			//css de estilos para o editor
			//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/editorHTML/assets/default/content.css");
			Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/assets-template/editorHTML/assets/default/content-personalizado.css?v=".time());

            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/assets-template/editorHTML/scripts/rangeslider.css");
			Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/assets-template/editorHTML/scripts/contentbuilder.css");

            Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/editorHTML/scripts/rangeslider.min.js');
            Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/editorHTML/scripts/contentbuilder.js');
            ?>
            <script type="text/javascript">
               jQuery(document).ready(function ($) {

                    $("#content_editor").contentbuilder({
						zoom:0,
                        model:'<?=get_class($model)?>',
                        snippetOpen: true,
                        snippetFile: '<?=Yii::app()->baseUrl?>/assets-template/editorHTML/assets/default/snippets.html'
                    });

                    $("#<?=$form->id?>").on("submit",function(){

                        preload_export_html = $('#content_editor').data('contentbuilder').html();
                        export_content = preload_export_html;

                        $("#content-field").val(export_content);
                    });
                });
            </script>
        </div>

<?php /*

HOW TO USE:

$this->renderPartial('//layouts/editor', array('model' => $model, 'form'=>$form, 'field'=>'descricao'));

*/ ?>
