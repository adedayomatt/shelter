<?php
error_reporting( E_ALL | E_ERROR | E_STRICT | E_PARSE);
function handleError($e_no, $e_str,$e_file,$e_line){
$errorLog = "
SCRIPT ERROR: 

Error code: [$e_no] 

Technical Message: $e_str 

File: $e_file 

Line: $e_line 

Page Accessing: ".$_SERVER['PHP_SELF'];
$error = new error();
$error->report_error(tools::error_message(),$errorLog,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
    }
	
set_error_handler("handleError");

require('param.php');

class database{
	public $connection = null;
	
	function __construct(){
		$connection = null;
		@$this->connection = new MySQLi(config::$db_host,config::$db_user,config::$db_password,config::$db_name);
		if ($this->connection->connect_error) {
			echo tools::no_connection_page();
			die();
			//error::report_error(general::no_connection_page(),$connect->error,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
		}
	}
	public function query_object($query){
		if($this->connection != null){
			$obj = $this->connection->query($query);
			if(!$this->connection->error){
				return $obj;
			}
			else{
				$e = new error();
				$e->report_error(tools::error_message(),'QUERY ERROR: '.$this->connection->error,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
			}
		}
		
	}

public function prepare_statement($statement){
		if($this->connection != null){
			$obj = $this->connection->prepare($statement);
			if(!$this->connection->error){
				return $obj;
			}
			else{
				$e = new error();
				$e->report_error(tools::error_message(),'STATEMENT PREPARATION ERROR: '.$this->connection->error,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
			}
		}
		
}

	public function close(){
		if($this->connection->close()){
			echo "<pre>connection closed</pre>";
			return true;
		}
		else{
			echo "<pre>connection failed to close</pre>";
			return false;
		}
	}

}


class tools extends database{
	public $one_day_timestamp = 86400;
	
	static function no_connection_page(){
		$page = "
			<html>
				<head>
					<title>Connection failed!</title>
				</head>
				<body style=\"background-color:#20435C;\">
					<div style=\"padding:10%; line-height:25px;color:white; text-align:center\">
						<img src=\"http://192.168.173.1/shelter/resrc/gifs/icon-wlan.gif\" style=\"width:200px; height:200px\"/>
						<h2 align=\"center\">No Connection to Server</h2>
						<p align=\"center\">Connection to the server could not be established. We are sorry for any inconviniency this might bring you and please be assured that we are working hard to resolve it soon</p>
					</div>
				</body>
			</html>
			";
		return $page;
    }
	
	static function unavailable_page(){
		$page = "
			<html>
				<head>
					<title>Page not Available!</title>
				</head>
				<body style=\"background-color:#20435C;\">
					<div style=\"padding:1%; width:70%;margin:auto; line-height:25px; background-color:white; color:#20435C;border-radius:5px\">
						<h2 align=\"center\">Page temporarily not available.</h2>
						<p align=\"center\">This page you are trying to view is temporarily not available, it may be under maintainance. We are sorry for any inconviniency this might bring you. You can <a href=\"$root\">visit our homepage</a></p>
					</div>
				</body>
			</html>
			";
		return $page;
	}
	
	static function error_message(){
		$msg = "
			<div style=\"background-color:white; color:red; width:90%;margin:5% auto;padding:20px;text-align:center; border:1px solid #e3e3e3;border-radius:5px;\">
				<h1> Ooops! Looks like something went wrong!</h1>
				<p>A problem has been encountered while loading this page,
				this error has been logged and please be assured that we'll get it fixed soon.</p>
			</div>
		";
		return $msg;
	}
	
	function cookieExist($cookie_name){
		return (isset($_COOKIE[$cookie_name]) ? true : false);
	}
	
	function getCookie($cookie_name){
		return ($this->cookieExist($cookie_name) == true ? $_COOKIE[$cookie_name] : "");
	}
	
	function deleteCookie($cookie_name){
		setcookie($cookie_name,"",time()-60,"/","",0);
	}
	function since($timestamp){
		$time = time() - $timestamp;
			if($time<60){
				$since = $time.'sec ago';
			}
			else if($time>=60 && $time<3600){
				$since = round(($time/60)).'min ago';
			}
			else if($time>=3600 && $time<86400){
				$since = round(($time/3600)).'h, '.(($time/60)%60).'min ago';
			}
			else if($time>=86400 && $time<604800){
				$since = round(($time/86400)).'d ago, '.date('l, M d ',$timestamp);
			}
			else if($time>=604800 && $time<18144000){
				$since =round(($time/604800)).'wk ago, '.date('M d  ',$timestamp);
			}
			else{
				$since = "invalid time";
			}
		return $since;
	}
		
	function substring($string,$beginningOrEnd,$length){
		if($beginningOrEnd == 'abc'){
			//return the first $length substring
			return (strlen($string) >= $length ? substr($string,0,$length).'...' : $string);
		}
		else if($beginningOrEnd == 'xyz'){
			//return the last $length substring
			return (strlen($string)>=$length ? '...'.substr($string,(strlen($string)-$length),strlen($string)) : $string);
		}
		else if($beginningOrEnd == 'abcxyz'){
			//return the part of the beginning substring and part of ending substring
			return (strlen($string)>=$length ? substr($string,0,($length/2)).'...'.substr($string,strlen($string)-($length/2),strlen($string)) : $string);
		}
	}
	
	function is_image($filename){
		$allowed = array(".png",".jpg",".jpeg");
		$i = 0;
		while($i < count($allowed)){
			if (stripos($filename,$allowed[$i]) == 0){
			$clean = false;
			}
			else{
				$clean = true;
				break;
			}
			$i++;
		}
		return $clean;
	}
	
	function is_upload_image($filetype){
		$allowedImageFormats = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
		if (in_array($filetype,$allowedImageFormats)){
			return true;
		}
		else{
			return false;
		}
	}
	
	function get_images($dir){
		$clean = array();
		$cleanFormats = array('.png','.PNG','.jpg','JPG','.jpeg','.pjpeg','.x-png');
		for($i = 0; $i<count($cleanFormats); $i++){
			foreach(glob("$dir/*$cleanFormats[$i]") as $c){
				$clean[] = $c;
			}
		}
		return $clean;
	}
	function relative_url(){
		$rel = "";
		$i = 2;
		while($i < substr_count($_SERVER['PHP_SELF'],'/')){
			$rel .= '../';
			$i++;
		}
		return $rel;
	}

	function clean_input($input){
		return $this->connection->real_escape_string(trim(htmlentities($input)));
	}

	function halt_page(){
		if($this->close()){
			echo "<pre>page halted!</pre>";
			die();
		}
		else{
			echo "<pre>page refused to halt: connection did not close</pre>";
		}
	}
	function redirect_to($url){
		GLOBAL $root;
		$goto = ($url=='home' ? $root : $url);
		$this->close();
		header("location: $goto");
		die();
	}	
}

class error extends tools{

	public function report_error($feedback,$msg,$file,$class,$function,$line){
		echo $feedback;
        $errorLog = "*** error: 
		$msg 
		Reported From: [$file >> $class :: $function >> at line $line] ***";
		$this->logError($errorLog);
	}
	
	public function logError($e){
		$logFile = $this->relative_url().config::$errorLog_path.'/error_log_'.time().'.txt';
		$file = fopen($logFile,"a+");
		$error = '['.date('Y : m : d : H : i : s',time()).'] 
	
		'.$e;
		if(fwrite($file,$error)){
			echo "<pre>error logged!</pre>";
		}else{
			echo "<pre>error not logged!</pre>";
		}
		fclose($file);
	
		if(file_exists($logFile)){
			echo "<pre>error has been reported!</pre>";
		}
		else{
			echo "<pre>Error not reported</pre>";
		}
		$this->halt_page();
	}
}





