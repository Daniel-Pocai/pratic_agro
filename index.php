<?php
// Nível de relatórios de erro (ajustado para produção)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

// Defina os caminhos para o framework Yii e para o arquivo de configuração
$yii = dirname(__FILE__) . '/yii/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// Verifica se estamos no ambiente de produção
$inProduction = getenv('HEROKU_APP_NAME') !== false;

// Ativa o modo de depuração apenas se NÃO estiver em produção
defined('YII_DEBUG') or define('YII_DEBUG', !$inProduction);

// Especifica quantos níveis da pilha de chamadas devem ser mostrados em cada mensagem de log
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// Redireciona para a rota correta se estiver acessando pela raiz
// No Heroku ou em produção, certifique-se de configurar o URL base corretamente
if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php') {
    header("Location: /web/extranet/protected/view/site/login.php");
    exit();
}

// Inclui o framework Yii e inicializa a aplicação
require_once($yii);
Yii::createWebApplication($config)->run();
