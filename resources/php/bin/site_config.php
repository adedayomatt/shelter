<?php

//SITE CONFIGURATIONS
class general_config{
	//static $root = "http://localhost/shelter";
		static $root = "http://192.168.173.1/shelter";

}

class database_config{
   static $HOST = '127.0.0.1';
   static $USER = 'adedayo';
   static $PASSWORD = 'matthew';
   static $DATABASE_NAME = 'shelter';
}

class upload_config{
static $max_photo = 10;
	
}
class properties_config{
	static $max_display = 5; 
    static $show_ad_after = 2;

}
class cta_config{
	
}
class agent_config{
	
}


$root = general_config::$root;
 $doc_root = $_SERVER['DOCUMENT_ROOT'].'/shelter/';
