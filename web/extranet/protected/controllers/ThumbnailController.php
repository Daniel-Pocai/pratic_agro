<?php

/*
thumbnail/fill/500x500/Empresa/brsis_teste_2_teste_novo_1456166364459.jpg
thumbnail/resize/500x500/Empresa/brsis_teste_2_teste_novo_1456166364459.jpg
thumbnail/crop/500x500/Empresa/brsis_teste_2_teste_novo_1456166364459.jpg
*/


class ThumbnailController extends GxController {


	public function renderizar($extensao,$arquivo_destino){
		ob_clean();
		ob_start();
		switch($extensao)
		{
			case 'jpg':
			case 'jpeg':
			case 'bmp':
			header( "Content-type: image/jpeg" );
			break;
			case 'png':
			header( "Content-type: image/png" );
			break;
			case 'gif':
				header( "Content-type: image/gif" );
				break;
				default:
				return false;
				break;
			}
			echo file_get_contents($arquivo_destino);
			exit;
		}

		public function base64($arquivo_destino){
			ob_clean();
			ob_start();
			$content = file_get_contents($arquivo_destino);
			echo 'data:image/'.end(explode(".",$arquivo)).';base64,';
			echo base64_encode($content);
			exit;
		}


		public function download($arquivo,$arquivo_destino){
			ob_clean();
			ob_start();
			header("Cache-Control: private");
			header("Content-Type: application/stream");
			header("Content-Disposition: attachment; filename=".$arquivo);

			echo file_get_contents($arquivo_destino);
			exit;
		}

		public function actionOriginal($model,$img) {
			$arquivo_destino = 'uploads/'.$model.'/'.$img;
			if($model=='gallery'){
				$arquivo_destino = $model.'/'.$img;
			}
			if(!is_file($arquivo_destino)){
				$arquivo_destino = 'img/imagem_nao_cadastrada.png';
			}
			$arr_ext = explode(".",$arquivo_destino);
			$aux_ext = end($arr_ext);
			$extensao = strtolower($aux_ext);
			$this->renderizar($extensao,$arquivo_destino);
		}

		public function actionRedimensionar($tipo,$dimensoes,$model,$img) {

			$dimensoes_array = explode('x',$dimensoes);
			$l = is_numeric($dimensoes_array[0]) ? $dimensoes_array[0] : 0;
			$a = is_numeric($dimensoes_array[1]) ? $dimensoes_array[1] : 0;

			$dir_thumbnail = 'uploads/'.$model.'/thumbnail';
			$dir_thumbnail_customizadas = 'uploads/'.$model.'/thumbnail-customizadas';

			$arquivo_destino = 'uploads/'.$model.'/'.$img;

			if($model=='gallery'){
				$dir_thumbnail = $model.'/thumbnail';
				$dir_thumbnail_customizadas = $model.'/thumbnail-customizadas';
				$arquivo_destino = $model.'/'.$img;
			}

			if(!is_dir($dir_thumbnail)){
				mkdir($dir_thumbnail,0775);
			}

			if(!is_dir($dir_thumbnail_customizadas)){
				mkdir($dir_thumbnail_customizadas,0775);
			}


			if(!is_file($arquivo_destino)){
				$arquivo_destino = 'img/imagem_nao_cadastrada.png';
				$this->renderizar($extensao,$arquivo_destino);
			}

			$arr_ext = explode(".",$arquivo_destino);
			$aux_ext = end($arr_ext);
			$extensao = strtolower($aux_ext);

			$rgb = '';
			if(isset($_GET['rgb'])){
				list($r, $g, $b) = explode('_', $_GET['rgb']);
				$rgb = "_".$r.$g.$b;
			}

			$arquivo_customizado = $dir_thumbnail_customizadas.'/'.str_replace(".","_".$tipo."_".$l."x".$a.$rgb.".",$img);
			if(is_file($arquivo_customizado)){
				$arquivo_destino = $arquivo_customizado;
			}
			else{
				$arquivo = $dir_thumbnail.'/'.str_replace(".","_".$tipo."_".$l."x".$a.$rgb.".",$img);
				if(!is_file($arquivo)){
					$oImg = new m2brimagem($arquivo_destino);
					if(!empty($rgb))
					$oImg->rgb($r, $g, $b);

					$valida = $oImg->valida();
					if ($valida == 'OK') {
						$oImg->redimensiona($l,$a,$tipo);
						$oImg->grava($arquivo);
					}
					else {
						die($valida);
					}
				}
				$arquivo_destino = $arquivo;
			}



			if($_GET['base64'] == 1){
				$this->base64($arquivo_destino);
			}
			elseif($_GET['dwn'] == 1){
				$this->download($arquivo,$arquivo_destino);
			}
			else{
				$this->renderizar($extensao,$arquivo_destino);
			}


		}

		public function actionSalvar(){

			$data = $_POST['base64'];
			$width = $_POST['width'];
			$height = $_POST['height'];
			$img_source = $_POST['img_source'];

			$explode_img = explode("/",$_POST['img_source']);
			$explode_qtd = count($explode_img);

			$img_arquivo = $explode_img[$explode_qtd-1];
			$pasta = $explode_img[$explode_qtd-2];

			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);


			$dir_thumbnail_customizadas = 'uploads/'.$pasta.'/thumbnail-customizadas';

			if($pasta=='gallery'){
				$dir_thumbnail_customizadas = $pasta.'/thumbnail-customizadas';
			}

			if(!is_dir($dir_thumbnail_customizadas)){
				mkdir($dir_thumbnail_customizadas,0775);
			}

			$tipo = 'crop';
			$l = $width;
			$a = $height;
			$rgb = '';

			$arquivo = $dir_thumbnail_customizadas.'/'.str_replace(".","_".$tipo."_".$l."x".$a.$rgb.".",$img_arquivo);

			file_put_contents($arquivo, $data);

			$oImg = new m2brimagem($arquivo);
			if(!empty($rgb))
			$oImg->rgb($r, $g, $b);

			$valida = $oImg->valida();
			if ($valida == 'OK') {
				$oImg->redimensiona($l,$a,$tipo);
				$oImg->grava($arquivo);
			}
			else {
				die($valida);
			}


			$this->retorno(array(
				'status' => true,
				'pasta' => $pasta,
				'arquivo' => $arquivo,
			));

		}

		public function retorno($data){
			ob_start();
			echo CJSON::encode($data);
			$output = ob_get_clean();
			ob_end_clean();
			echo $output;
			Yii::app()->end();
		}


	}
