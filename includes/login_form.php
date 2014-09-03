<?php 

 echo'<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">';


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
						<form method="post" action="'.$server_url.'/index.php" role="form">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="password" type="password" value="" required>
								</div>
								<button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
							</fieldset>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div> 
  ';
 
html_header_end(); 


?>