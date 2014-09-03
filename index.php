<?php
// my coment
<<<<<<< HEAD
// А это мой. И твой не исчез!
=======
// А это мой. И твой не исчез! 
// A esli udaliti
>>>>>>> origin/master



require_once('includes/define.php'); 
include($aplication_doc_root.'/functions/functions.php');  

/* pg_connections

$dbpg = start_pg_session($pg_connect,$nume_cont);
close_pg_session($dbpg);
*/

html_header_start($server_url);
?>

<body>
<?php
if (!isset($_SESSION['id_utilizator'])) include($aplication_doc_root.'/includes/login_form.php');
else
	{
/*		$id_utilizator = $_SESSION['id_utilizator'];
		$nume_cont = $_SESSION['nume_cont'];
		$rol_asociat = $_SESSION['rol_asociat'];
		$nume_utilizator = $_SESSION['nume_utilizator'];
		$prenume_utilizator = $_SESSION['prenume_utilizator'];

		echo $id_utilizator.'</br>';
		echo $nume_cont.'</br>';
		echo $rol_asociat.'</br>';hhh
		echo $nume_utilizator.'</br>';
		echo $prenume_utilizator.'</br>';
*/

echo '
<script>
<!--
location.replace("'.$server_url.'/includes/main_frame_sheet.php");
-->
</script>
';

//	header($aplication_doc_root.'/includes/main_frame_sheet.php');
//	include($aplication_doc_root.'/includes/main_frame_sheet.php');

//echo getContent($aplication_doc_root.'/includes/main_frame_sheet.php');

}
?>



<?php html_header_end(); ?>