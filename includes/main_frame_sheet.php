<?php
require_once('define.php');
include($aplication_doc_root.'/functions/functions.php');

if (isset($_SESSION['id_utilizator']))
{
	$id_utilizator = $_SESSION['id_utilizator'];
	$nume_cont = $_SESSION['nume_cont'];
	$rol_asociat = $_SESSION['rol_asociat'];
	$nume_utilizator = $_SESSION['nume_utilizator'];
	$prenume_utilizator = $_SESSION['prenume_utilizator'];
	if (isset($_GET['a'])) $_SESSION['action'] = $_GET['a'];
	if (isset($_SESSION['action'])) $action = $_SESSION['action']; else $action = ""; 
}
else $action = "exit";

/*
echo 'id '.$id_utilizator.'</br>';
echo 'nume '.$nume_cont.'</br>';
echo 'rol '.$rol_asociat.'</br>';
echo 'nu '.$nume_utilizator.'</br>';
echo 'pu '.$prenume_utilizator.'</br>';
*/
html_header_start($server_url);
echo "<body>"; 
echo 
'
<!-- ------------------------------- Top menu ------------------------------- -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sistemul informaţional ULIM</a>
        </div>
        <div class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="active"><a href="'; echo $server_url; echo'/includes/main_frame_sheet.php">Home</a></li>
            <li><a href="#about">Help</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrare<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="'; echo $server_url; echo'/includes/main_frame_sheet.php?a=administrare_cont#">Administrare cont</a></li>
                <li><a href="#">Test</a></li>
                <li><a href="#">Test</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Test header</li>
                <li><a href="#">Test</a></li>
                <li><a href="#">Test</a></li>
              </ul>
            </li>

            <li><a href="'; echo $server_url; echo'/includes/main_frame_sheet.php?a=exit">Iesire</a></li>
          </ul>
        </div>
      </div>
    </div>

<!-- ------------------------------- left menu ------------------------------- -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 sidebar">
           <ul class="nav nav-sidebar">
            <li class="active"><a href="'; echo $server_url; echo'/includes/main_frame_sheet.php?a=nom_discipline">Discipline</a></li>
            <li><a href="'; echo $server_url; echo'/includes/main_frame_sheet.php?a=nom_plan_studii">Plan de studii</a></li>
            <li><a href="'; echo $server_url; echo'/includes/main_frame_sheet.php?a=grupe">Administrare grupe</a></li>
          </ul>
        </div>

<!-- ------------------------------- Center ------------------------------- -->

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 main">';
        	switch ($action)
		     { 
			 case "": 						echo show_alert('success','Autentificare reuşită.'); break;
			 case "administrare_cont": 		include($aplication_doc_root.'/actions_result/administrare_cont_result.php'); break;
			 case "nom_discipline": 		include($aplication_doc_root.'/actions_result/nom_discipline_result.php'); break;
			 case "nom_plan_studii": 		include($aplication_doc_root.'/actions_result/nom_plan_studii_result.php'); break;
			 case "grupe": 					include($aplication_doc_root.'/actions_result/grupe_result.php'); break;

			 case "exit": 					session_destroy(); 
			 								echo 
			 									'<script> 
			 										<!-- 
			 										location.replace("'.$server_url.'"); 
			 										--> 
			 										</script>
			 									'; 
			 								break;

			 }  
        echo'</div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">right menu</div>
      </div>
    </div>  


<table width=100% height=100% >
	<tr>
		<td width=20% valign="top"> 
';
/*
switch ($rol_asociat)
		     { 
			 case "1": 		include($aplication_doc_root.'/menu/menu_rol_1.php'); break;
			 case "2": 		include($aplication_doc_root.'/menu/menu_rol_2.php'); break;
//			 case "3": 		echo '<frame src="'.$server_url.'/menu/menu_rol_3.php">'; break;
			 }   
*/
echo 
'
</td>
<td valign="top">
';

 

echo 
'
		</td>
	</tr>
</table>
';
echo "
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
    <script src=\"../bootstrap/js/bootstrap.js\"></script>
    </body>";
html_header_end();

?>