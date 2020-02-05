<?php

define("DOMAIN", "http://jspb.zzz.com.ua/");

function getDbConnect($_serv = null){
  
	$dbHost = "mysql.zzz.com.ua";
	$dbName = "johny_smoke";
	$dbUser = "johnysmoke";
	$dbPass = "J22yrytZdCYnZA2";
  
	$con=@mysql_connect($dbHost, $dbUser, $dbPass);
    if( false  ===  $con){
        print_r('Connection failed');
		return false;
    }
    
    @mysql_query("SET NAMES 'utf8';", $con);
    @mysql_query("SET CHARACTER SET 'utf8';", $con);

    @mysql_query ("set character_set_client='utf8'", $con);
    @mysql_query ("set character_set_results='utf8'", $con);
    @mysql_query ("set collation_connection='utf8_general_ci'", $con);

    if(@mysql_select_db($dbName, $con)){
        return $con;
    }else{
        return false;
    }
}


?>