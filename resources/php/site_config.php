<?php

//SITE CONFIGURATIONS
class general_config{
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
	static $max_display = 12; 
    static $show_ad_after = 3;

}
class cta_config{
	
}
class agent_config{
	
}
class ads{
static $ad001 = '';
static $ad002 = '';
}

$root = general_config::$root;
//$general_config_obj = new general_config();

