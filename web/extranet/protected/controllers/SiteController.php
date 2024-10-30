<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),

			'uploadStreaming'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
            ),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(Yii::app()->user->isGuest)
			$this->redirect($this->createUrl("login"));
		else
			$this->actionSalesReport();
    	}
		

	public function actionSalesReport()
    {
        $sql = "SELECT r.nome AS representante, COUNT(h.idvenda) AS total_vendas, SUM(h.valor_total) AS valor_total
                FROM representante r
                LEFT JOIN 	historico_vendas h ON r.idrepresentante = h.idrepresentante
                GROUP BY r.idrepresentante, r.nome";

        $command = Yii::app()->db->createCommand($sql);
        $data = $command->queryAll();

        $representativeCount = count($data); 
        $clientCount = Cliente::model()->count();

        $this->render('index', [
            'data' => $data,
            'representativeCount' => $representativeCount,
            'clientCount' => $clientCount,
        ]);
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest)
			$this->redirect("site");
		$model=new LoginForm;


		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			return true;
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		elseif(isset($_GET['email']) && isset($_GET['senha'])){
			$model->email = $_GET['email'];
			$model->senha = $_GET['senha'];
			if($model->login($senha_encript = true))
				$this->redirect('usuario/update?id='.Yii::app()->user->obj->idusuario);
		}

		// display the login form
		$this->renderPartial('login',array('model'=>$model),false,true);
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionActions($controller){
		$controller_class = ucwords($controller).'Controller';
		$actions = Yii::app()->metadata->getActions($controller_class);

		$action_return = array();

		foreach($actions as $action){
			if($controller == 'site' || Yii::app()->user->obj->perfil->temPermissaoAction($controller,$action))
				$action_return[strtolower($action)] = Dicionario::acao($action);
		}

		echo CJSON::encode(array(
			'status' => true,
			'actions' => $action_return,
		));
		return true;

	}

	public function actionEsqueci_senha(){
		if($_POST['RecuperarSenha']){
			$criteria = new CDbCriteria();
			$criteria->addCondition("habilitar = '1'");
			$criteria->addCondition("email = '".$_POST['RecuperarSenha']['email']."'");
			$usuario = Usuario::model()->find($criteria);
			if(is_object($usuario)){
				$usuario->enviarEmailRecuperarSenha();
				$this->redirect($this->createUrl('esqueci_senha',array('msg_sucesso'=>"Utilize o link enviado para o e-mail ".$usuario->email." para alterar sua senha")));
			}
			else{
				$erro = "E-mail não encontrado";
			}
		}
		$this->renderPartial('esqueci_senha',array(
			'erro' => $erro,
		),false,true);

	}

	public function actionRecuperacao_senha(){

		if (empty($_GET['token'])) {
			$this->render('erro',array(
				'erro' => "Link de recuperação de senha inválido",
			));
			return true;
		}

		# verifica se existe usuario com este e-mail e senha...
		$criteria = new CDbCriteria();
		$criteria->addCondition("token = :token");
		$criteria->addCondition("data_validade >= '".date('Y-m-d H:i:s')."'");
		$criteria->addCondition("utilizado != '1' OR utilizado IS NULL");
		$criteria->params = array(":token" => $_GET['token']);
		$cliente_recupera_senha = UsuarioRecuperaSenha::model()->find($criteria);


		//Token invï¿½lido
		if(!is_object($cliente_recupera_senha)){

			$this->renderPartial('//layouts/erro',array(
				'erro' => 'Link de recuperaï¿½ï¿½o de senha invï¿½lido',
			),false,true);
			return true;
		}

		$erro = "";

		if(is_array($_POST['RecuperarSenha'])){

			$usuario = $cliente_recupera_senha->usuario;

			$usuario->scenario = 'insert';
			$usuario->senha = $_POST['RecuperarSenha']['senha'];
			$usuario->senha_confirma = $_POST['RecuperarSenha']['senha_confirma'];

			if($usuario->validate(array('senha','repita_senha'))){

				$usuario->updateByPk($usuario->idusuario,array(
					'senha'=>$usuario->cryptoSenha($usuario->senha)
				));

				$cliente_recupera_senha->updateByPk($cliente_recupera_senha->idusuario_recupera_senha,array(
					'utilizado'=>'1',
					'utilizado_ip'=> $_SERVER["REMOTE_ADDR"],
					'utilizado_data'=> date('Y-m-d H:i:s'),
				));
				$this->redirect($this->createUrl('login',array('msg_sucesso'=>"Senha alterada com sucesso, por favor, realize login com a nova senha")));


			}
			else{
				$erro = CHtml::errorSummary($usuario);
			}

		}

		$this->renderPartial('recuperacao_senha',array(
			'erro' => $erro,
		),false,true);
	}

	public function actionCidades(){
		$uf = $_GET['uf'];
        $id = $_GET['id'];
        $criteria = new CDbCriteria();
        
        if(is_numeric($id)) {
            $uf = Estado::model()->findByPk($id)->uf;
        }

        if ($uf) {
            $criteria->addCondition("uf = :uf");
                $criteria->params = array(
                ':uf'=>$uf,
            );
        }
		$cidades = Cidade::model()->findAll($criteria);
		$cidades_list = CHtml::listData($cidades,'idcidade','nome');
		echo CJSON::encode($cidades_list);
		return true;
	}


	public function actionUpload(){

		$dir = 'uploads/'.$_GET['model'].'/';

		if(!is_dir($dir) && strpos($_GET['model'],'..') == false && strpos($_GET['model'],'/') == false)
			mkdir($dir, 0777, true);

		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

		$array_type = array(
			'image/png',
			'image/jpg',
			'image/gif',
			'image/jpeg',
			'image/pjpeg',
		);

		if (in_array($_FILES['file']['type'],$array_type) && $_GET['type'] == 'image'){
			$file = $dir.md5(date('YmdHis')).'.jpg';
		}
		else{
			$file = $dir.Util::file_encode($_FILES['file']['name']);
		}

		move_uploaded_file($_FILES['file']['tmp_name'], $file);

		$array = array(
			'filelink' => Yii::app()->createAbsoluteUrl($file),
			'filename' => ($_FILES['file']['name'])
		);

		echo CJSON::encode($array);
		return true;
	}

	public function actionPlupload(){
		ob_clean();
		ob_start();

		// HTTP headers for no cache etc
		header('Content-type: text/plain; charset=UTF-8');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// Settings
		$targetDir = "uploads/".$_GET['class']."/";
		if(!is_dir($targetDir) && strpos($_GET['class'],'..') == false && strpos($_GET['class'],'/') == false){
			mkdir($targetDir,777);
		}

		$cleanupTargetDir = false; // Remove old files
		$maxFileAge = 60 * 60; // Temp file age in seconds

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}


		// Remove old temp files
		if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// Remove temp files if they are older than the max age
				if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
					@unlink($filePath);
			}

			closedir($dir);
		} else
			die(utf8_encode('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Diretï¿½rio inexistente ou sem permissï¿½o de escrita."}, "id" : "id"}'));

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die(utf8_encode('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Falha no upload."}, "id" : "id"}'));
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die(utf8_encode('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Falha no upload."}, "id" : "id"}'));
			} else
				die(utf8_encode('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Diretï¿½rio inexistente ou sem permissï¿½o de escrita."}, "id" : "id"}'));
		} else {
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die(utf8_encode('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}'));

				fclose($in);
				fclose($out);
			} else
				die(utf8_encode('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}'));
		}

		// Return JSON-RPC response
		die(utf8_encode('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}'));
		ob_end_flush();
	}

	public function actionBase64upload(){
		$status = false;
		$nome_arquivo = '';
		$link_arquivo = '';
		/*CREATE IMAGE FROM BASE64*/
		$classe = $_POST['model'];
		/*$field_base64 = $field.'_base64';*/

		$dir_up = 'uploads/'.$classe;
		if(!is_dir($dir_up)){
			mkdir($dir_up,0775);
		}


		if(!empty($_POST['img'])){
			$status = true;
			$data = $_POST['img'];
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			$data = base64_decode($data);

			$nome_arquivo = 'contenteditor_'.time().'.jpg';
			$link_arquivo = 'uploads/'.$classe.'/'.$nome_arquivo;
			file_put_contents($link_arquivo, $data);


		}
		/**********************/

		$array = array(
			'status' => $status,
			'imgname' => $nome_arquivo,
			'image' => Yii::app()->baseUrl.'/'.$link_arquivo,
		);

		echo CJSON::encode($array);
		return true;
	}

}
