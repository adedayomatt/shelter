<?php
	require('config.php');
/***********this part is just for the matthews******/
if(isset($matthews) && $matthews == true){
	config::$root_folder="matthews";
}
/**************************************************/
$server = ((isset(config::$local_server) || config::$local_server !="") ? config::$local_server : '');
$server_doc_root = $_SERVER['DOCUMENT_ROOT'];
$doc_root = $server_doc_root.'/'.config::$root_folder;
$errorlog_path = $doc_root.'/'.config::$errorLog_path;
$root = 'http'.(isset($_SERVER['HTTPS']) ? 's' : '' ).'://'.$server.'/'.config::$root_folder;
$script_running = $_SERVER['PHP_SELF'];
$current_url = 'http'.(isset($_SERVER['HTTPS']) ? 's' : '' ).'://'.$server.$_SERVER['REQUEST_URI'];
