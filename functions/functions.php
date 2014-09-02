<?php

function db_user_define($siu_user,$dbpg)
{
	$sql = "CREATE TEMPORARY TABLE current_setting (siu_user varchar(40));
			INSERT INTO current_setting (siu_user) VALUES ('".$siu_user."');";

	pg_query($dbpg, $sql);
}

function start_pg_session($pg_connect,$siu_user)
{
	$dbpg = pg_connect($pg_connect);
	db_user_define($siu_user,$dbpg);
	return $dbpg;
}

function close_pg_session($dbpg)
{
	pg_close($dbpg);
}

function getHtml($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);    
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function html_header_start($server_url)
{
    echo'
        <html>
            <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">    
            <title>Sistemul informaţional ULIM</title>
            <link href="'.$server_url.'/css/styles.css" rel="stylesheet">
            <!-- Bootstrap core CSS -->
                <link href="'.$server_url.'/bootstrap/css/bootstrap.css" rel="stylesheet">
            <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
       ';
}

function html_header_end()
{
    echo "</html>";
}

function show_alert($tipe, $message)
    {
       echo"<div class=\"alert alert-$tipe\" role=\"alert\">$message</div>";         
    }

?>