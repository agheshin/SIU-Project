<?php
require_once('../includes/define.php');
include($aplication_doc_root.'/functions/functions.php');

html_header_start();

echo 
'
<p>Nu aţi introdus corect informaţia de logare.</p>
<a href="'.$server_url.'">Încearca din nou.</a></br>
';

html_header_end();
?>