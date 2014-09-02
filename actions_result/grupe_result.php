<?php
if(isset($_SESSION['id_utilizator']))
{
// add form new grupa
	if (isset($_GET['n']))
	{
	   	$dbpg = start_pg_session($pg_connect,$nume_cont);

		echo 
			'
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=grupe" method="POST">
			<input type="hidden" name="nou" value="">
			<table>
				<tr>
					<td>Denumire grupa:</td>
					<td><input type="text" name="denumire" value=""></td>
				</tr>
				<tr>
					<td>Specialitatea:</td>
					<td>
						<select name="id_specialitate">';

			$sql1="SELECT * FROM bdsiu.nom_specialitate ORDER BY cod";
			$result1 = pg_query($dbpg, $sql1);
			while ($row1 = pg_fetch_array($result1))
			{
					echo '
						<option value="'.$row1['id_specialitate'].'">'.$row1['cod'].' - '.$row1['denumire'].'</option>';
			}

		echo 
		'
						</select>
					</td>
				</tr>
				<tr>
					<td>Catedra:</td>
					<td>
						<select name="id_catedra">';

			$sql1="SELECT * FROM bdsiu.nom_catedra ORDER BY id_catedra";
			$result1 = pg_query($dbpg, $sql1);
			while ($row1 = pg_fetch_array($result1))
			{
					echo '
						<option value="'.$row1['id_catedra'].'">'.$row1['denumire'].'</option>';
			}

			echo 
		'
						</select>
					</td>
				</tr>
				<tr>
					<td>Anul de studii:</td>
					<td>
						<select name="id_an_de_studii">';		

			$sql1="SELECT * FROM bdsiu.nom_an_de_studii ORDER BY id_an_de_studii";
			$result1 = pg_query($dbpg, $sql1);
			while ($row1 = pg_fetch_array($result1))
			{
					echo '
						<option value="'.$row1['id_an_de_studii'].'">'.$row1['denumire'].'</option>';
			}

		echo 
		'
						</select>
					</td>
				</tr>
				<tr>
					<td>Anul de studii:</td>
					<td>
						<select name="id_limba_instruire">';		

			$sql1="SELECT * FROM bdsiu.nom_limba_de_instruire ORDER BY id_limba_de_instruire";
			$result1 = pg_query($dbpg, $sql1);
			while ($row1 = pg_fetch_array($result1))
			{
					echo '
						<option value="'.$row1['id_limba_de_instruire'].'">'.$row1['denumire'].'</option>';
			}

		echo 
		'
						</select>
					</td>
				</tr>
				<tr>
					<td>Plan de studii asociat:</td>
					<td>
						<select name="id_plan_studii">';		

			$sql1="SELECT * FROM bdsiu.nom_plan_studii ORDER BY denumire";
			$result1 = pg_query($dbpg, $sql1);
			while ($row1 = pg_fetch_array($result1))
			{
					echo '
						<option value="'.$row1['id_plan_studii'].'">'.$row1['denumire'].'</option>';
			}

		echo 
		'
						</select>
					</td>
				</tr>
				<tr>
					<td>Nr. studenti inscrisi:</td>
					<td><input type="text" name="nr_studenti_inscrisi" value=""></td>
				</tr>
				<tr>
					<td>Nr. studenti achitat:</td>
					<td><input type="text" name="nr_studenti_achitat" value=""></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="Salveaza"></tdf>
				</tr>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=grupe" method="POST">
				<tr>
					<td colspan=2><input type="submit" value="Renunţă"></tdf>
				</tr>
			</form>
			</table>
			';
	    close_pg_session($dbpg);
	}

// save new grupa
	else if (isset($_POST['nou']))
	{

	    $dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "
			INSERT INTO bdsiu.grupe(
				id_grupa,
				denumire,
				id_specialitate,
				id_catedra,
				id_limba_instruire,
				id_an_de_studii,
				nr_studenti_inscrisi,
				nr_studenti_achitat,
				id_plan_studii)
			VALUES(
				nextval('bdsiu.grupe_seq'),
				'".$_POST['denumire']."',
				'".$_POST['id_specialitate']."',
				'".$_POST['id_catedra']."',
				'".$_POST['id_limba_instruire']."',
				'".$_POST['id_an_de_studii']."',
				'".$_POST['nr_studenti_inscrisi']."',
				'".$_POST['nr_studenti_achitat']."',
				'".$_POST['id_plan_studii']."')
	    ";
		pg_query($dbpg, $sql);

		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=grupe");
				-->
			</script>
		';

	}

// delete grupa
	else if (isset($_GET['sterge']))
	{
   		$dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "DELETE FROM bdsiu.grupe WHERE (id_grupa='".$_GET['id_grupa']."')";
		pg_query($dbpg, $sql);
		close_pg_session($dbpg);
		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=grupe");
				-->
			</script>
		';
	}


	else if (isset($_GET['action']))
	{
		echo "action";
	}

// afisare grupe
	else
	{
	    $rowmax = '0';
   		$sql="
			SELECT
				gr.id_grupa AS id_grupa,
				gr.denumire AS denumire,
				gr.id_specialitate AS id_specialitate,
				gr.id_catedra AS id_catedra,
				gr.id_limba_instruire AS id_limba_instruire,
				gr.id_an_de_studii AS id_an_de_studii,
				gr.nr_studenti_inscrisi AS nr_studenti_inscrisi,
				gr.nr_studenti_achitat AS nr_studenti_achitat,
				gr.id_plan_studii AS id_plan_studii,
				ns.denumire AS denumire_specialitate,
				nc.denumire AS denumire_catedra,
				nf.denumire AS denumire_facultate,
				nads.denumire AS denumire_an_de_studii
			FROM
				bdsiu.grupe AS gr
				INNER JOIN bdsiu.nom_specialitate AS ns ON gr.id_specialitate = ns.id_specialitate
				INNER JOIN bdsiu.nom_catedra AS nc ON gr.id_catedra = nc.id_catedra
				INNER JOIN bdsiu.nom_facultate AS nf ON nc.id_facultate = nf.id_facultate
				INNER JOIN bdsiu.nom_an_de_studii AS nads ON gr.id_an_de_studii = nads.id_an_de_studii
		";	

    	$dbpg = start_pg_session($pg_connect,$nume_cont);
	    $result = pg_query($dbpg, $sql);
	    close_pg_session($dbpg);

	    while ($row = pg_fetch_array($result))
	    {
	        $rowmax ++;

	        $_NDR[$rowmax]['id_grupa'] = $row['id_grupa'];
	        $_NDR[$rowmax]['denumire'] = $row['denumire'];
	        $_NDR[$rowmax]['id_specialitate'] = $row['id_specialitate'];
	        $_NDR[$rowmax]['id_catedra'] = $row['id_catedra'];
	        $_NDR[$rowmax]['id_limba_instruire'] = $row['id_limba_instruire'];
	        $_NDR[$rowmax]['id_an_de_studii'] = $row['id_an_de_studii'];
	        $_NDR[$rowmax]['nr_studenti_inscrisi'] = $row['nr_studenti_inscrisi'];
	        $_NDR[$rowmax]['nr_studenti_achitat'] = $row['nr_studenti_achitat'];
	        $_NDR[$rowmax]['id_plan_studii'] = $row['id_plan_studii'];
			$_NDR[$rowmax]['denumire_specialitate'] = $row['denumire_specialitate'];
			$_NDR[$rowmax]['denumire_catedra'] = $row['denumire_catedra'];
			$_NDR[$rowmax]['denumire_facultate'] = $row['denumire_facultate'];
			$_NDR[$rowmax]['denumire_an_de_studii'] = $row['denumire_an_de_studii'];

	    }

	    echo '
			<a href="'.$server_url.'/includes/main_frame_sheet.php?a=grupe&n=new">adaoga o grupa</a></br></br>
	        <table>
	            <tr>
	                <td>Nr.</td>
	                <td>Denumire</td>
	                <td>An</td>
	                <td>Specialitatea</td>
	                <td>Facultatea</td>
   	                <td>Actiune</td>
	            </td>
	    ';

	    $i = '0';

	    while ($i < $rowmax)
	    {
	        $i ++;
	        echo'
	            <tr>
	                <td>'.$i.'</td>
	                <td><a href="'.$server_url.'/includes/main_frame_sheet.php?a=grupe&id_grupa='.$_NDR[$i]['id_grupa'].'">'.$_NDR[$i]['denumire'].'</a></td>
	                <td>'.$_NDR[$i]['denumire_an_de_studii'].'</td>
	                <td>'.$_NDR[$i]['denumire_specialitate'].'</td>
	                <td>'.$_NDR[$i]['denumire_facultate'].'</td>
	                <td><a href="'.$server_url.'/includes/main_frame_sheet.php?a=grupe&id_grupa='.$_NDR[$i]['id_grupa'].'&sterge=1">Sterge</a></td>
	            </td>
	        ';
	    }

	    echo '
	        </table>
	    ';


	}
}
else 
{
echo 
'<html>
Login error!
</html>'; 
}
?>
