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
    <!DOCTYPE html>
        <html lang="en">
        <html>
            <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">    
            <title>Sistemul informaţional ULIM</title>
     
            <!-- Bootstrap Core CSS -->
            <link href="'.$server_url.'/css/bootstrap.min.css" rel="stylesheet">

            <!-- MetisMenu CSS -->
            <link href="'.$server_url.'/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="'.$server_url.'/css/sb-admin-2.css" rel="stylesheet">

            <!-- Custom Fonts -->
            <link href="'.$server_url.'/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn t work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        </head>
       ';
}

function html_header_end($server_url)
{
    echo '
    <!-- jQuery Version 1.11.0 -->
    <script src="'.$server_url.'/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="'.$server_url.'/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="'.$server_url.'/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="'.$server_url.'/js/sb-admin-2.js"></script>
    </html>
    </body>
    ';
}

function show_alert($tipe, $message)
    {
       echo"<div class=\"alert alert-$tipe\" role=\"alert\">$message</div>";         
    }

?>