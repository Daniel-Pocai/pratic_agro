<?
class InjectionBlocker{

    public static $htmlentities;

	public static function run($htmlentities = true){
        self::$htmlentities = $htmlentities;
        
		InjectionBlocker::recursiveFilter($_REQUEST);
		InjectionBlocker::recursiveFilter($_GET);
		InjectionBlocker::recursiveFilter($_POST);
	}
	
    public static function safeStringMySQL($string){
        include(dirname(__FILE__).'/../config/main-db.php');
        $link = mysqli_connect($db['host'], $db['username'], $db['password']);
        $string_ok = mysqli_real_escape_string($link,$string);
        return($string_ok);
    }

    public static function safeStringXSS($string){
        $data = urldecode($string);
       
		$caracter[] = "'";
		$replace[] = "`";
        
		
        if(InjectionBlocker::$htmlentities){
            $caracter[] = "<";
		    $replace[] = "&lt;";

            $caracter[] = ">";
		    $replace[] = "&gt";

            $caracter[] = '"';
		    $replace[] = "``";
        }

        $data =  str_replace($caracter,$replace,$data);
        return $data;
    }

	public static function filter($data){
        $data = InjectionBlocker::safeStringXSS($data);
        //$data = InjectionBlocker::safeStringMySQL($data);
		return $data; 
	}
	
	public static function recursiveFilter(&$input) {
		if (is_string($input)) {
			$input = InjectionBlocker::filter($input);
		} 
		else if (is_array($input)) {
			foreach ($input as &$value) {
				InjectionBlocker::recursiveFilter($value);
			}
			unset($value);
		} 
		else if (is_object($input)) {
			$vars = array_keys(get_object_vars($input));
			foreach ($vars as $var) {
				InjectionBlocker::recursiveFilter($input->$var);
			}
		}
	}
	
}