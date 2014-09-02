<div>
<h1 class="page-header">Discipline</h1>
<?php
 
//	start edit form nom_discipline
if (isset($_GET['id_disciplina']))
{

	$dbpg = start_pg_session($pg_connect,$nume_cont);
	$sql="
		SELECT
		nd.id_disciplina AS id_disciplina,
		nd.cod AS cod,
		nd.denumire AS denumire,
		nd.denumire_en AS denumire_en,
		nd.id_catedra AS id_catedra,
		nd.de_la AS de_la,
		nd.pina_la AS pina_la,
		nc.denumire AS denumire_catedra
		FROM
		bdsiu.nom_discipline AS nd
		LEFT JOIN bdsiu.nom_catedra AS nc ON nd.id_catedra = nc.id_catedra
		WHERE id_disciplina = ".$_GET['id_disciplina']."
	";

	$result = pg_query($dbpg, $sql);
	$row = pg_fetch_array($result);

	$_NDR['id_disciplina'] = $row['id_disciplina'];
	$_NDR['cod'] = $row['cod'];
	$_NDR['denumire'] = $row['denumire'];
	$_NDR['denumire_en'] = $row['denumire_en'];
	$_NDR['id_catedra'] = $row['id_catedra'];
	$_NDR['de_la'] = $row['de_la'];
	$_NDR['pina_la'] = $row['pina_la'];
	$_NDR['denumire_catedra'] = $row['denumire_catedra'];

	echo 
		'
		<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline" method="POST" role="form">
		<input type="hidden" name="modificare" value="">
		<input type="hidden" name="id_disciplina" value="'.$_NDR["id_disciplina"].'">
		
		<div class="form-group">
			<label>Codul disciplinei:</label>
			<input type="text" name="cod" value="'.$_NDR["cod"].'" class="form-control">
		</div>
		<div class="form-group">
			<label>Denumire:</label>
			<input type="text" name="denumire" value="'.$_NDR["denumire"].'" class="form-control">
		</div>
		<div class="form-group">
			<label>Denumire:</label>
			<input type="text" name="denumire_en" value="'.$_NDR["denumire_en"].'" class="form-control">
		</div>					
			
		';

	if(isset($_SESSION['id_catedra']))
	{
		echo '
        <div class="form-group">
			<label>De la:</label>
			<input type="date" name="de_la" value="'.$_NDR["denumire_catedra"].'" class="form-control">
		</div>
		<input type="hidden" name="id_catedra" value="'.$_NDR['id_catedra'].'">
		';
	}

	else
	{
		echo'  
		<label>Catedra:</label>
		<select name="id_catedra" class="form-control">';

		$sql1="SELECT * FROM bdsiu.nom_catedra ORDER BY id_catedra";
		$result1 = pg_query($dbpg, $sql1);
		while ($row1 = pg_fetch_array($result1))
			{
			if($row1['id_catedra'] == $_NDR['id_catedra'])
				echo '<option value="'.$row1['id_catedra'].'" selected="selected">'.$row1['denumire'].'</option>';
			else 
				echo '<option value="'.$row1['id_catedra'].'">'.$row1['denumire'].'</option>';
			}

	    echo '</select>	';

	}

	echo'
		<div class="form-group">
			<label>De la:</label>
			<input type="date" name="de_la" value="'.$_NDR["de_la"].'" class="form-control">
		</div>
		<div class="form-group">
			<label>Pînă la:</label>
			<input type="date" name="pina_la" value="'.$_NDR["pina_la"].'" class="form-control">
		</div>
		<input type="submit" value="Modifică informaţia" class="btn btn-primary">			
		</form>
		<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline" method="POST">
			<input type="submit" value="Renunţă"  class="btn btn-success">			
		</form>		
	';

	close_pg_session($dbpg);

}
//	end of edit form nom_discipline

// start of save chandes in nom_discipline 

else if(isset($_POST['modificare']))
{
//	echo "Modificarea datelor pentru disciplina ".$_POST['id_disciplina'];
	if ($_POST['pina_la'] == "") $pina_la = "null"; else $pina_la = "'".$_POST["pina_la"]."'";
   
    $dbpg = start_pg_session($pg_connect,$nume_cont);
    $sql = "
    	UPDATE bdsiu.nom_discipline 
    		SET 
    			cod = '".$_POST['cod']."', 
    			denumire = '".$_POST['denumire']."', 
    			denumire_en = '".$_POST['denumire_en']."', 
    			id_catedra = '".$_POST['id_catedra']."', 
    			de_la = '".$_POST['de_la']."', 
    			pina_la = ".$pina_la." 
    		WHERE id_disciplina = ".$_POST['id_disciplina']."
    ";
	$result = pg_query($dbpg, $sql);

	close_pg_session($dbpg);

	echo '
		<script>
			<!--
			location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline");
			-->
		</script>
	';

}
// end of save chandes in nom_discipline 

// start form new nom_discipline 

else if (isset($_GET['n']))
{

	echo 
		'
		<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline" method="POST" role="form">
		<input type="hidden" name="nou" value="">
		<div class="form-group">
			<label>Codul disciplinei:</label>
			<input type="text" name="cod" value="" class="form-control">
		</div>
		<div class="form-group">
			<label>Denumire:</label>
			<input type="text" name="denumire" value="" class="form-control">
		</div>
		<div class="form-group">
			<label>Denumire:</label>
			<input type="text" name="denumire_en" value="" class="form-control">
		</div>		
		';

	if(isset($_SESSION['id_catedra']))
	{
	    $dbpg = start_pg_session($pg_connect,$nume_cont);
		$sql = "SELECT * FROM bdsiu.nom_catedra WHERE bdsiu.nom_catedra.id_catedra = '".$_SESSION['id_catedra']."'";
		$result = pg_query($dbpg, $sql);
		$row = pg_fetch_array($result);
		echo'
		<div class="form-group">
			<label>Catedra:</label>
			<input type="date" name="de_la" value="" class="'.$row["denumire"].' class="form-control"">
		</div>
		<input type="hidden" name="id_catedra" value="'.$row['id_catedra'].'">
		';
		close_pg_session($dbpg);
	}

	else
	{
		echo'
		<div class="form-group">
			<label>Catedra:</label>		
			<select name="id_catedra" class="form-control">
		';

		$dbpg = start_pg_session($pg_connect,$nume_cont);	
		$sql="SELECT * FROM bdsiu.nom_catedra ORDER BY id_catedra";
		$result = pg_query($dbpg, $sql);
		while ($row = pg_fetch_array($result))
		{
			echo 
			'
				<option value="'.$row['id_catedra'].'">'.$row['denumire'].'</option>
			';
		}
		close_pg_session($dbpg);

		echo'</select>
		</div>';
	}


	echo'
		<div class="form-group">
			<label>De la:</label>
			<input type="date" name="de_la" value="'.date("Y-m-d").'" class="form-control">
		</div>
		<div class="form-group">
			<label>Pînă la:</label>
			<input type="date" name="pina_la" value="" class="form-control">
		</div>	
		<input type="submit" value="Salvează" class="btn btn-primary">
		</form>
		<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline" method="POST">
			<input type="submit" value="Renunţă" class="btn btn-success">
		</form>		
	';

}
// end of form new nom_discipline 

// start save form new nom_discipline 
else if (isset($_POST['nou']))
{
	if ($_POST['pina_la'] == "") $pina_la = "null"; else $pina_la = "'".$_POST["pina_la"]."'";
   
    $dbpg = start_pg_session($pg_connect,$nume_cont);
    $sql = "
		INSERT INTO bdsiu.nom_discipline(
			id_disciplina,
			cod,
			denumire,
			denumire_en,
			id_catedra,
			de_la,
			pina_la)
		VALUES(
			nextval('bdsiu.nom_discipline_seq'),
			'".$_POST['cod']."',
			'".$_POST['denumire']."',
			'".$_POST['denumire_en']."',
			'".$_POST['id_catedra']."',
			'".$_POST['de_la']."',
			".$pina_la.")
    ";
	$result = pg_query($dbpg, $sql);

	close_pg_session($dbpg);

	echo '
		<script>
			<!--
			location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline");
			-->
		</script>
	';

}
// end of save form new nom_discipline 

// start display all nom_discipline 
else 

{
    $rowmax = '0';

    $dbpg = start_pg_session($pg_connect,$nume_cont);

    if(isset($_SESSION['id_catedra'])) 
    	{
    		$sql="
				SELECT
				nd.id_disciplina AS id_disciplina,
				nd.cod AS cod,
				nd.denumire AS denumire,
				nd.denumire_en AS denumire_en,
				nd.id_catedra AS id_catedra,
				nd.de_la AS de_la,
				nd.pina_la AS pina_la,
				nc.denumire AS denumire_catedra
				FROM
				bdsiu.nom_discipline AS nd
				LEFT JOIN bdsiu.nom_catedra AS nc ON nd.id_catedra = nc.id_catedra
				WHERE id_catedra = ".$_SESSION['id_catedra']."
				OR id_catedra is null
				ORDER BY  denumire_catedra, denumire 
			";	
    	
    	}
    else if(isset($_SESSION['if_facultate'])) 
    	{
    		$sql="
				SELECT
					nd.id_disciplina AS id_disciplina,
					nd.cod AS cod,
					nd.denumire AS denumire,
					nd.denumire_en AS denumire_en,
					nd.id_catedra AS id_catedra,
					nd.de_la AS de_la,
					nd.pina_la AS pina_la,
					nc.denumire AS denumire_catedra,
					nf.denumire AS denumire_facultate,
					nc.id_facultate AS id_facultate
				FROM
					bdsiu.nom_discipline AS nd
					LEFT JOIN bdsiu.nom_catedra AS nc ON nd.id_catedra = nc.id_catedra
					LEFT JOIN bdsiu.nom_facultate AS nf ON nc.id_facultate = nf.id_facultate
				WHERE
					nd.id_catedra = ".$_SESSION['id_facultate']." OR
					nd.id_catedra IS null
				ORDER BY
					denumire_catedra ASC
			";	
    	
    	}
    else 
    	{
    		$sql="
				SELECT
				nd.id_disciplina AS id_disciplina,
				nd.cod AS cod,
				nd.denumire AS denumire,
				nd.denumire_en AS denumire_en,
				nd.id_catedra AS id_catedra,
				nd.de_la AS de_la,
				nd.pina_la AS pina_la,
				nc.denumire AS denumire_catedra
				FROM
				bdsiu.nom_discipline AS nd
				LEFT JOIN bdsiu.nom_catedra AS nc ON nd.id_catedra = nc.id_catedra
				ORDER BY  denumire_catedra, denumire 
			";	
    	}

    $result = pg_query($dbpg, $sql);


    while ($row = pg_fetch_array($result))
    {
        $rowmax ++;

        $_NDR[$rowmax]['id_disciplina'] = $row['id_disciplina'];
        $_NDR[$rowmax]['cod'] = $row['cod'];
        $_NDR[$rowmax]['denumire'] = $row['denumire'];
        $_NDR[$rowmax]['denumire_en'] = $row['denumire_en'];
        $_NDR[$rowmax]['id_catedra'] = $row['id_catedra'];
        $_NDR[$rowmax]['de_la'] = $row['de_la'];
        $_NDR[$rowmax]['pina_la'] = $row['pina_la'];
		$_NDR[$rowmax]['denumire_catedra'] = $row['denumire_catedra'];

    }
    close_pg_session($dbpg);

    echo '
		<a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline&n=new" class="btn btn-primary">Disciplină nouă</a></br></br>
        <table class="table table-striped">
            <tr>
                <td>Nr.</td>
                <td>Cod</td>
                <td>Denumire</td>
                <td>Denumire (tradus)</td>
                <td>Catedra</td>
            </td>
    ';

    $i = '0';

    while ($i < $rowmax)
    {
        $i ++;
        echo'
            <tr>
                <td>'.$i.'</td>
                <td>'.$_NDR[$i]['cod'].'</td>
                <td><a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_discipline&id_disciplina='.$_NDR[$i]['id_disciplina'].'">'.$_NDR[$i]['denumire'].'</a></td>
                <td>'.$_NDR[$i]['denumire_en'].'</td>
                <td>'.$_NDR[$i]['denumire_catedra'].'</td>
            </td>
        ';
    }

    echo '
        </table>
    ';
}
// end of display all nom_discipline 

?>


</div>