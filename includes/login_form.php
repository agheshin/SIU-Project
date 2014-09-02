<?php 

 echo'<div class="container"> ';


 if(isset($_POST['username'])) 
 	{ 

	$username=$_POST['username'];
	$password=$_POST['password'];
	
	$dbpg = start_pg_session($pg_connect,"");

	$sql="SELECT * FROM bdsiu.utilizatori_sistem WHERE bdsiu.utilizatori_sistem.nume_cont = '".$username."'"; 
	$result = pg_query($dbpg, $sql);
	while ($row = pg_fetch_array($result))
	{
		$id_utilizator = $row['id_utilizator'];
		$nume_cont = $row['nume_cont'];
		$parola = $row['parola'];
		$rol_asociat = $row['rol_asociat'];
		$nume_utilizator = $row['nume_utilizator'];
		$prenume_utilizator = $row['prenume_utilizator'];
		$de_la = $row['de_la'];
		$pina_la = $row['pina_la'];
	}

	close_pg_session($dbpg);
	
	if($password==$parola) 
	   { 
		if($de_la < date('Y-m-d'))
		 {
		 	if(($pina_la > date('Y-m-d')) or ($pina_la == ""))
		 	{
//		 		session_name('siu');
//		 		session_start();
		 		$_SESSION['id_utilizator'] = $id_utilizator;
				$_SESSION['nume_cont'] = $nume_cont;
				$_SESSION['rol_asociat'] = $rol_asociat;
				$_SESSION['nume_utilizator'] = $nume_utilizator;
				$_SESSION['prenume_utilizator'] = $prenume_utilizator;
				header("Location: ".$server_url."/index.php"); 
				exit;	
		 	} 
		 	else 
		 	{
		 		echo show_alert('warning','Nu aţi introdus corect informaţia de logare');  
		 	}
		 } 
	 	 else 
	 	 {
		 	 
		 	echo show_alert('warning','Nu aţi introdus corect informaţia de logare'); 
		 }
	  } 
		else 
		{
			echo show_alert('warning','Nu aţi introdus corect informaţia de logare'); 
		}
   }

 

echo '  
<form method="post" action="'.$server_url.'/index.php" class="form-signin" role="form">
<h2 class="form-signin-heading">Please sign in</h2>
    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus><label></label>
    <input type="password" class="form-control" placeholder="Password" name="password" required><label></label>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>	
</form>
</div> 
  ';
 echo "
    <!-- Bootstrap core JavaScript ================================================== ++ -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
    <script src=\"$server_url/bootstrap/js/bootstrap.js\"></script>
    </body>";
html_header_end(); 


?>