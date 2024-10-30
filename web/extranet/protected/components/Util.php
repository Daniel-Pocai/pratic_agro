<?
define("LATIN1_UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ");
define("LATIN1_LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý");

class Util{

	/*
	//Exemplos de formatação de data
	$data_teste = '28/06/1987 23:22:00';
	echo "data: ".Util::formataDataHora($data_teste,'dd/MM/yyyy HH:mm:ss','d/m/Y H:i');
	echo "<br/>data_app: ".Util::formataDataApp('1987-06-28');
	echo "<br/>data_hora_app: ".Util::formataDataHoraApp('1987-06-28 23:22:21');
	echo "<br/>data_bd: ".Util::formataDataBanco('28/06/1987');
	echo "<br/>data_hora_bd: ".Util::formataDataHoraBanco('28/06/1987 23:22:21');
	*/

	public static function formataDataBanco($data){
		return Util::formataDataHora($data,Yii::app()->locale->getDateFormat(),'Y-m-d');
	}

	public static function formataDataHoraBanco($data){
		return Util::formataDataHora($data,Yii::app()->locale->getDateFormat().' '.Yii::app()->locale->getTimeFormat(),'Y-m-d H:i:s');
	}

	public static function formataDataHoraApp($data){
		return Util::formataDataHora($data,'yyyy-MM-dd HH:mm:ss','d/m/Y H:i:s');
	}

	public static function formataDataApp($data){
		return Util::formataDataHora($data,'yyyy-MM-dd','d/m/Y');
	}

	public static function resumeData($data){
		return substr($data,0,11);
	}

	public static function formataDataHora($data,$formato_entrada,$formato_saida){
		$tamanho_string = strlen($formato_entrada);
		$data = substr($data,0,$tamanho_string);
		$data = str_pad($data,$tamanho_string,':00');
		return date($formato_saida,CDateTimeParser::parse($data,$formato_entrada));
	}

	public static function formataTexto($texto_original){

		$texto = htmlentities($texto_original, ENT_QUOTES,'ISO-8859-1');

		$array_encontrar = array(
			"\n",
			"–",
		);
		$array_substituir = array(
			"<br/>",
			"-",
		);

		$texto = str_replace($array_encontrar,$array_substituir,$texto);

		return $texto;
	}

	public static function formataResumo($textoInteiro,$tamanho){
		$textoInteiro = strip_tags($textoInteiro);
		if (strlen($textoInteiro)>$tamanho+25){
			$posicao = strpos($textoInteiro ," ", $tamanho);
			$textoParcial = substr ($textoInteiro, 0, $posicao); //Pega o fragmento e elimina todas as tags html, caso existam.
			$textoParcial .= "...";
		}
		else{
			$textoParcial = strip_tags($textoInteiro);
		}
		return Util::formataTexto($textoParcial);
	}

	public static function file_encode($var) {

		$var = strtolower($var);

		$var = preg_replace("[áàâãª]","a",$var);
		$var = preg_replace("[éèê]","e",$var);
		$var = preg_replace("[íìî]","i",$var);
		$var = preg_replace("[óòôõº]","o",$var);
		$var = preg_replace("[úùû]","u",$var);
		$var = preg_replace("[+]","",$var);
		$var = str_replace("ç","c",$var);
		$var = str_replace(" ","_",$var);


		return $var;
	}


	public static function soNumero($str) {
		return preg_replace("/[^0-9]/", "", $str);
	}

	public static function soLetras($str) {
		return preg_replace("/[^a-zA-Z\s]/", "", $str);
	}

	public static function formataMoedaFloat($valor) {
		$valor  = str_replace(".","",$valor);
		$valor  = str_replace(",",".",$valor);
		return number_format((float)$valor,2,'.','');
	}

	public static function formataFloatMoeda($valor) {
		return number_format($valor,2,',','.');
	}

	public static function redirect($prox_pagina){
		$url = Yii::app()->baseUrl.'/'.$prox_pagina;

		if(strpos($prox_pagina, 'http://')!==FALSE||strpos($prox_pagina, 'https://')!==FALSE){
			$url = $prox_pagina;
			?>
			<script language="JavaScript">
			var win = window.open( '<?= $url ?>', '_blank');
			win.focus();
			</script>
			<?php
			return false;
		}
		?>
		<script language="JavaScript">
		location.href = '<?= $url ?>';
		</script>
		<?php
		exit;
	}

	public static function removerAcentos($string) {
		$string = strtolower($string);
		$string = rtrim($string);
		$string = ltrim($string);
		$string = preg_replace("/[áàâãä]/", "a", $string);
		$string = preg_replace("/[ªº]/", "", $string);
		$string = preg_replace("/[ÁÀÂÃÄÄ]/", "A", $string);
		$string = preg_replace("/[éèêëë]/", "e", $string);
		$string = preg_replace("/[ÉÈÊË]/", "E", $string);
		$string = preg_replace("/[íìï]/", "i", $string);
		$string = preg_replace("/[ÍÌÏ]/", "I", $string);
		$string = preg_replace("/[óòôõö]/", "o", $string);
		$string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
		$string = preg_replace("/[úùü]/", "u", $string);
		$string = preg_replace("/[ÚÙÜ]/", "U", $string);
		$string = preg_replace("/ç/", "c", $string);
		$string = preg_replace("/Ç/", "C", $string);
		$string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
		$string = preg_replace("/ /", "-", $string);
		$string = str_replace("--", "-", $string);
		$string = str_replace("--", "-", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("´", "", $string);
		$string = str_replace('"', "", $string);

		return $string;
	}

	public static function getMesExtenso($data){
        $m =  array(
            '01'=>'Janeiro',
            '02'=>'Fevereiro',
            '03'=>'Março',
            '04'=>'Abril',
            '05'=>'Maio',
            '06'=>'Junho',
            '07'=>'Julho',
            '08'=>'Agosto',
            '09'=>'Setembro',
            '10'=>'Outubro',
            '11'=>'Novembro',
            '12'=>'Dezembro',
        );
        return $m[Util::getMes($data)];
    }
    public static function getMesAbr($data){
        $m =  array(
            '01'=>'JAN',
            '02'=>'FEV',
            '03'=>'MAR',
            '04'=>'ABR',
            '05'=>'MAI',
            '06'=>'JUN',
            '07'=>'JUL',
            '08'=>'AGO',
            '09'=>'SET',
            '10'=>'OUT',
            '11'=>'NOV',
            '12'=>'DEZ',
        );
        return $m[Util::getMes($data)];
    }

    public static function getDataExtenso($data){
        return substr($data,0,2).' de '.Util::getMesExtenso($data).' de '.Util::getAno($data);
    }

    public static function getDia($data){
        return substr($data,0,2);
    }
    public static function getMes($data){
        return substr($data,3,2);
    }
    public static function getAno($data){
        return substr($data,6,4);
    }

    function mascara($mask,$str){
        $str = str_replace(" ","",$str);

        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }

        return $mask;

    }

    public function formataCPF_CNPJ($cpf_cnpj){
        if(empty($cpf_cnpj))
            return '';
        $cpf_cnpj = Util::soNumero($cpf_cnpj);

        if(strlen($cpf_cnpj) <= 11){
           $cpf_cnpj =  Util::mascara("###.###.###-##",$cpf_cnpj);
        }
        else{
            $cpf_cnpj =  Util::mascara("##.###.###/####-##",$cpf_cnpj);
        }
        return $cpf_cnpj;
    }

    public function formataCPF_CNPJ_numero($cpf_cnpj){
        $cpf_cnpj = Util::soNumero($cpf_cnpj);
        return $cpf_cnpj;
    }

    public static function maiusculo($str){
        $str = strtoupper(strtr($str, LATIN1_LC_CHARS, LATIN1_UC_CHARS));
        return $str;
    }

    public static function minusculo($str){
        $str = strtolower(strtr($str, LATIN1_UC_CHARS,LATIN1_LC_CHARS));
        return $str;
    }

    public static function debug($dados, $exit = false){
        echo '<pre>';
        print_r($dados);
        echo '</pre>';
        if($exit){
            exit;
        }
    }

    public static function formataErros($model,$concat = "\n"){
        $erros_retorno = array();
        if(count($erros = $model->getErrors()) > 0){
            foreach($erros as $erro){
                if(is_array($erro)){
                    foreach($erro as $err){
                        $erros_retorno[] = $err;
                    }
                }
                else
                $erros_retorno[] = $erro;
            }
        }
        return implode($concat,$erros_retorno);
    }

}
