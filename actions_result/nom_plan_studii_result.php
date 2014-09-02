<?php
if(isset($_SESSION['id_utilizator']))
{
	echo'<h1 class="page-header">Plan de studii</h1>';
	echo "<div>";

// Start form for new nom_plan_studii
	if(isset($_GET['n']))
	{
		echo 
			'
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
			<input type="hidden" name="nou" value="">
			<table>
				<tr>
					<td>Denumirea Planului de studii:</td>
					<td><input type="text" name="denumire" value=""></td>
				</tr>
				<tr>
					<td>Nr. de înregistrare a Planului de studii:</td>
					<td><input type="text" name="nr_plan_cadru" value=""></td>
				</tr>
				<tr>
					<td>Data înregistrării:</td>
					<td><input type="date" name="data_plan_cadru" value=""></td>
				</tr>
			';

			echo 
			'
				<tr>
					<td>Specialitatea:</td>
					<td>
						<select name="id_specialitate">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql = 
			"
				SELECT * FROM bdsiu.nom_specialitate ORDER BY bdsiu.nom_specialitate.cod
			";
			
			$result = pg_query($dbpg, $sql);
			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_specialitate'].'">'.$row['cod'].' - '.$row['denumire'].'</option>
				';
			}
			close_pg_session($dbpg);

			echo 
			'
							</select>
						</td>
					</tr>
			';


		if(isset($_SESSION['id_facultate']))
		{
		    $dbpg = start_pg_session($pg_connect,$nume_cont);
			$sql = "SELECT * FROM bdsiu.nom_facultate WHERE bdsiu.nom_facultate.id_facultate = '".$_SESSION['id_facultate']."'";
			$result = pg_query($dbpg, $sql);
			$row = pg_fetch_array($result);
			echo
			'
				<tr>
					<td>Facultatea:</td>
					<td><input type="date" name="de_la" value="'.$row["denumire"].'" readonly></td>
				</tr>
					<input type="hidden" name="id_facultate" value="'.$row['id_facultate'].'"></td>
			';
			close_pg_session($dbpg);
		}

		else
		{
			echo 
			'
				<tr>
					<td>Facultatea:</td>
					<td>
						<select name="id_facultate">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_facultate ORDER BY id_facultate";
			$result = pg_query($dbpg, $sql);
			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_facultate'].'">'.$row['denumire'].'</option>
				';
			}
			close_pg_session($dbpg);

			echo 
			'
							</select>
						</td>
					</tr>
			';
		}


		echo
		'
				<tr>
					<td>Nr. total de credite:</td>
					<td><input type="text" name="nr_total_credite" value=""></td>
				</tr>
				<tr>
					<td>De la:</td>
					<td><input type="date" name="de_la" value="'.date("Y-m-d").'"></td>
				</tr>
				<tr>
					<td>Pînă la:</td>
					<td><input type="date" name="pina_la" value=""></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="Salvează"></tdf>
				</tr>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
				<tr>
					<td colspan=2><input type="submit" value="Renunţă"></tdf>
				</tr>
			</form>
			</table>
		';

	}

// save new nom_plan_studii	
	else if(isset($_POST['nou']))
	{
		if ($_POST['de_la'] == "") $de_la = "null"; else $de_la = "'".$_POST["de_la"]."'";
		if ($_POST['pina_la'] == "") $pina_la = "null"; else $pina_la = "'".$_POST["pina_la"]."'";

		$dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "
			INSERT INTO bdsiu.nom_plan_studii(
				id_plan_studii,
				nr_plan_cadru,
				data_plan_cadru,
				denumire,
				id_specialitate,
				id_facultate,
				nr_total_credite,
				de_la,
				pina_la)
			VALUES(
				nextval('bdsiu.nom_plan_studii_seq'),
				'".$_POST['nr_plan_cadru']."',
				'".$_POST['data_plan_cadru']."',
				'".$_POST['denumire']."',
				'".$_POST['id_specialitate']."',
				'".$_POST['id_facultate']."',
				'".$_POST['nr_total_credite']."',
				".$de_la.",
				".$pina_la.")
	    ";
		pg_query($dbpg, $sql);
		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii");
				-->
			</script>
		';
	}

// add new asoc_ps_cod	
	else if(isset($_GET['nou_apc']))
	{
		$_NPSR['id_plan_studii'] = $_GET['id_plan_studii'];

		echo 
		'
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
			<input type="hidden" name="nou_apc" value="">
			<input type="hidden" name="id_plan_studii" value="'.$_NPSR['id_plan_studii'].'">
			<table class="table table-striped">
				<tr>
					<td>Cod:</td>
					<td><input type="text" name="cod" value=""></td>
				</tr>
				<tr>
					<td>Anul de studii:</td>
					<td>
						<select name="id_an_de_studii">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_an_de_studii ORDER BY id_an_de_studii";
			$result = pg_query($dbpg, $sql);
			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_an_de_studii'].'">'.$row['denumire'].'</option>
				';
			}
			close_pg_session($dbpg);

			echo 
			'
							</select>
					</td>
				</tr>
				<tr>
					<td>Semestrul:</td>
					<td>
						<select name="id_semestru">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_semestru ORDER BY id_semestru";
			$result = pg_query($dbpg, $sql);
			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_semestru'].'">'.$row['denumire'].'</option>
				';
			}
			close_pg_session($dbpg);

			echo 
			'
							</select>
					</td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="Salvează"></tdf>
				</tr>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'" method="POST">
				<tr>
					<td colspan=2><input type="submit" value="Renunţă"></tdf>
				</tr>
			</form>
			</table>
		';

	}

// save new asoc_pc_cod
	else if(isset($_POST['nou_apc']))
	{
		$dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "
			INSERT INTO bdsiu.asoc_ps_cod(
				id_asoc_ps_cod,
				id_plan_studii,
				cod,
				id_an_de_studii,
				id_semestru)
			VALUES(
				nextval('bdsiu.asoc_ps_cod_seq'),
				'".$_POST['id_plan_studii']."',
				'".$_POST['cod']."',
				'".$_POST['id_an_de_studii']."',
				'".$_POST['id_semestru']."')
	    ";
		pg_query($dbpg, $sql);
		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_POST['id_plan_studii'].'");
				-->
			</script>
		';
	}

// start form asociere modul / curs existent
	else if(isset($_GET['add_apcm']))
	{
		$_NPSR['id_plan_studii'] = $_GET['id_plan_studii'];
		$_NPSR['id_asoc_ps_cod'] = $_GET['id_asoc_ps_cod'];

		echo 
		'
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
			<input type="hidden" name="add_apcm" value="">
			<input type="hidden" name="id_plan_studii" value="'.$_NPSR['id_plan_studii'].'">
			<input type="hidden" name="id_asoc_ps_cod" value="'.$_NPSR['id_asoc_ps_cod'].'">
			<table>
				<tr>
					<td>Denumire modul / curs:</td>
					<td>
						<select name="id_modul">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_module ORDER BY cod";
			$result = pg_query($dbpg, $sql);
			close_pg_session($dbpg);

			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_modul'].'">'.$row['cod'].' - '.$row['denumire'].'</option>
				';
			}
			
			echo 
			'
							</select>
					</td>
				</tr>
				<tr>
				<td>Forma de evaluare:</td>
					<td>
						<select name="id_forma_de_evaluare">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_forma_de_evaluare ORDER BY id_forma_de_evaluare";
			$result = pg_query($dbpg, $sql);
			close_pg_session($dbpg);

			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_forma_de_evaluare'].'">'.$row['denumire'].'</option>
				';
			}
			
			echo 
			'
							</select>
					</td>
				</tr>
				<tr>
					<td>Numărul de credite:</td>
					<td><input type="text" name="nr_credite" value=""></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="Salvează"></tdf>
				</tr>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'" method="POST">
				<tr>
					<td colspan=2><input type="submit" value="Renunţă"></tdf>
				</tr>
			</form>
			</table>
		';

	}

// save form asoc_pc_cod_modur
	else if(isset($_POST['add_apcm']))
	{
		$dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "
			INSERT INTO bdsiu.asoc_ps_cod_modul(
				id_asoc_ps_cod_modul,
				id_modul,
				id_asoc_ps_cod,
				id_forma_de_evaluare,
				nr_credite)
			VALUES(
				nextval('bdsiu.asoc_ps_cod_modul_seq'),
				'".$_POST['id_modul']."',
				'".$_POST['id_asoc_ps_cod']."',
				'".$_POST['id_forma_de_evaluare']."',
				'".$_POST['nr_credite']."')
	    ";
		pg_query($dbpg, $sql);
		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_POST['id_plan_studii'].'");
				-->
			</script>
		';
	}

// start form new modul / curs existent
	else if(isset($_GET['new_apcm']))
	{
		$_NPSR['id_plan_studii'] = $_GET['id_plan_studii'];
		$_NPSR['id_asoc_ps_cod'] = $_GET['id_asoc_ps_cod'];

		echo 
		'
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
			<input type="hidden" name="new_apcm" value="">
			<input type="hidden" name="id_plan_studii" value="'.$_NPSR['id_plan_studii'].'">
			<input type="hidden" name="id_asoc_ps_cod" value="'.$_NPSR['id_asoc_ps_cod'].'">
			<table>
				<tr>
					<td>Cod modul/curs:</td>
					<td><input type="text" name="cod" value=""></td>
				</tr>
				<tr>
					<td>Denumire:</td>
					<td><input type="text" name="denumire" value=""></td>
				</tr>
				<tr>
					<td>Denumire (tradus):</td>
					<td><input type="text" name="denumire_en" value=""></td>
				</tr>
				<tr>
				<td>Forma de evaluare:</td>
					<td>
						<select name="id_forma_de_evaluare">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_forma_de_evaluare ORDER BY id_forma_de_evaluare";
			$result = pg_query($dbpg, $sql);
			close_pg_session($dbpg);

			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_forma_de_evaluare'].'">'.$row['denumire'].'</option>
				';
			}
			
			echo 
			'
							</select>
					</td>
				</tr>
				<tr>
					<td>Numărul de credite:</td>
					<td><input type="text" name="nr_credite" value=""></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="Salvează"></tdf>
				</tr>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'" method="POST">
				<tr>
					<td colspan=2><input type="submit" value="Renunţă"></tdf>
				</tr>
			</form>
			</table>
		';
	}

// save form new modul
	else if(isset($_POST['new_apcm']))
	{
		$dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "
			INSERT INTO bdsiu.nom_module(
				id_modul,
				cod,
				denumire,
				denumire_en)
			VALUES(
				nextval('bdsiu.nom_module_seq'),
				'".$_POST['cod']."',
				'".$_POST['denumire']."',
				'".$_POST['denumire_en']."')
	    ";
		pg_query($dbpg, $sql);

	    $sql = "
			INSERT INTO bdsiu.asoc_ps_cod_modul(
				id_asoc_ps_cod_modul,
				id_modul,
				id_asoc_ps_cod,
				id_forma_de_evaluare,
				nr_credite)
			VALUES(
				nextval('bdsiu.asoc_ps_cod_modul_seq'),
				currval('bdsiu.nom_module_seq'),
				'".$_POST['id_asoc_ps_cod']."',
				'".$_POST['id_forma_de_evaluare']."',
				'".$_POST['nr_credite']."')
	    ";
		pg_query($dbpg, $sql);

		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_POST['id_plan_studii'].'");
				-->
			</script>
		';
	}

// start form asoc_pc_modul_disciplina
	else if(isset($_GET['add_dis']))
	{	
		$_NPSR['id_plan_studii'] = $_GET['id_plan_studii'];
		$_NPSR['id_asoc_ps_cod_modul'] = $_GET['id_asoc_ps_cod_modul'];

		echo 
		'
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
			<input type="hidden" name="add_dis" value="">
			<input type="hidden" name="id_plan_studii" value="'.$_NPSR['id_plan_studii'].'">
			<input type="hidden" name="id_asoc_ps_cod_modul" value="'.$_NPSR['id_asoc_ps_cod_modul'].'">
			<table>
				<tr>
				<td>Disciplina:</td>
					<td>
						<select name="id_disciplina">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);	
			$sql="SELECT * FROM bdsiu.nom_discipline ORDER BY cod";
			$result = pg_query($dbpg, $sql);
			close_pg_session($dbpg);

			while ($row = pg_fetch_array($result))
			{
				echo 
				'
					<option value="'.$row['id_disciplina'].'">'.$row['cod'].' - '.$row['denumire'].'</option>
				';
			}
			
			echo 
			'
							</select>
					</td>
				</tr>
				<tr>
					<td>Ore (contact direct):</td>
					<td><input type="text" name="nr_ore_contact_direct" value=""></td>
				</tr>
				<tr>
					<td>Ore (studiu individual):</td>
					<td><input type="text" name="nr_ore_studiu_individual" value=""></td>
				</tr>
				<tr>
					<td>Ore (curs):</td>
					<td><input type="text" name="nr_ore_curs" value=""></td>
				</tr>
				<tr>
					<td>Ore (seminar):</td>
					<td><input type="text" name="nr_ore_seminarii" value=""></td>
				</tr>
				<tr>
					<td>Ore (laborator):</td>
					<td><input type="text" name="nr_ore_laborator" value=""></td>
				</tr>
				<tr>
					<td colspan=2><input type="submit" value="Salvează"></tdf>
				</tr>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'" method="POST">
				<tr>
					<td colspan=2><input type="submit" value="Renunţă"></tdf>
				</tr>
			</form>
			</table>
		';

	}

// save form asoc_pc_modul_disciplina
	else if(isset($_POST['add_dis']))
	{
	    $sql = "
			INSERT INTO bdsiu.asoc_ps_modul_discipline(
				id_asoc_ps_modul_discipline,
				id_disciplina,
				id_asoc_ps_cod_modul,
				nr_ore_contact_direct,
				nr_ore_studiu_individual,
				nr_ore_curs,
				nr_ore_seminarii,
				nr_ore_laborator)
			VALUES(
				nextval('bdsiu.asoc_ps_modul_discipline_seq'),
				'".$_POST['id_disciplina']."',
				'".$_POST['id_asoc_ps_cod_modul']."',
				'".$_POST['nr_ore_contact_direct']."',
				'".$_POST['nr_ore_studiu_individual']."',
				'".$_POST['nr_ore_curs']."',
				'".$_POST['nr_ore_seminarii']."',
				'".$_POST['nr_ore_laborator']."')
	    ";

		$dbpg = start_pg_session($pg_connect,$nume_cont);
		pg_query($dbpg, $sql);
		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_POST['id_plan_studii'].'");
				-->
			</script>
		';
	}

// administrare plan studii	
	else if(isset($_GET['id_plan_studii']))
	{
	$sql = 
		'
		SELECT
			nps.denumire AS denumire,
			nps.nr_plan_cadru AS nr_plan_studii,
			nps.data_plan_cadru AS data_plan_studii,
			ns.cod AS cod_specialitate,
			ns.denumire AS denumire_specialitate,
			nf.denumire AS denumire_facultate,
			nps.id_plan_studii AS id_plan_studii,
			nps.id_specialitate AS id_specialitate,
			nps.id_facultate AS id_facultate,
			nps.nr_total_credite AS nr_total_credite,
			nps.de_la AS de_la,
			nps.pina_la AS pina_la
		FROM
			bdsiu.nom_plan_studii AS nps
			INNER JOIN bdsiu.nom_specialitate AS ns ON nps.id_specialitate = ns.id_specialitate
			INNER JOIN bdsiu.nom_facultate AS nf ON nps.id_facultate = nf.id_facultate
		WHERE id_plan_studii = '.$_GET["id_plan_studii"].'
			';

		$dbpg = start_pg_session($pg_connect,$nume_cont);
		$result = pg_query($dbpg, $sql);
		$row = pg_fetch_array($result);
		close_pg_session($dbpg);

		$_NPSR['denumire'] = $row['denumire'];
		$_NPSR['nr_plan_studii'] = $row['nr_plan_studii'];
		$_NPSR['data_plan_studii'] = $row['data_plan_studii'];
		$_NPSR['cod_specialitate'] = $row['cod_specialitate'];
		$_NPSR['denumire_specialitate'] = $row['denumire_specialitate'];
		$_NPSR['denumire_facultate'] = $row['denumire_facultate'];
		$_NPSR['id_plan_studii'] = $row['id_plan_studii'];
		$_NPSR['id_specialitate'] = $row['id_specialitate'];
		$_NPSR['id_facultate'] = $row['id_facultate'];
		$_NPSR['nr_total_credite'] = $row['nr_total_credite'];
		$_NPSR['de_la'] = $row['de_la'];
		$_NPSR['pina_la'] = $row['pina_la'];


		echo 
		'	Informaţie generală Plan de studii:
			<table>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
			<input type="hidden" name="modificare_ps" value="">
			<input type="hidden" name="id_plan_studii" value="'.$_NPSR["id_plan_studii"].'">
				<tr>
					<td>Denumire</td>
					<td>Nr. de înregistrare</td>
					<td>Data înregistrării</td>
				</tr>
				<tr>
					<td><input type="text" name="denumire" value="'.$_NPSR["denumire"].'"></td>
					<td><input type="text" name="nr_plan_cadru" value="'.$_NPSR["nr_plan_studii"].'"></td>
					<td><input type="date" name="data_plan_cadru" value="'.$_NPSR["data_plan_studii"].'"></td>
				</tr>
				<tr>
					<td colspan=2>Specialitatea</td>
					<td>Facultatea</td>
				</tr>
				<tr>
					<td colspan=2>
						<select name="id_specialitate">
		';

		$dbpg = start_pg_session($pg_connect,$nume_cont);
		$sql="SELECT * FROM bdsiu.nom_specialitate ORDER BY bdsiu.nom_specialitate.cod";
		$result = pg_query($dbpg, $sql);
		while ($row = pg_fetch_array($result))
		{
			if($row['id_specialitate'] == $_NPSR['id_specialitate'])
				echo '
					<option value="'.$row['id_specialitate'].'" selected="selected">'.$row['cod'].' - '.$row['denumire'].'</option>';

			else 
				echo '
					<option value="'.$row['id_specialitate'].'">'.$row['cod'].' - '.$row['denumire'].'</option>';
		}
		close_pg_session($dbpg);

		echo 
		'
						</select>
					</td>
					<td>
		';
		if(isset($_SESSION['id_facultate']))
		{
			echo '
				<input type="hidden="id_facultate" value="'.$_NPSR["id_facultate"].'">
				<input type="text" name="denumire_facultate" value="'.$_NPSR["denumire_facultate"].'" readonly>
			';
		}
		else
		{
			echo '
							<select name="id_facultate">
			';

			$dbpg = start_pg_session($pg_connect,$nume_cont);
			$sql="SELECT * FROM bdsiu.nom_facultate ORDER BY bdsiu.nom_facultate.id_facultate";
			$result = pg_query($dbpg, $sql);
			while ($row = pg_fetch_array($result))
			{
				if($row['id_facultate'] == $_NPSR['id_facultate'])
					echo '
						<option value="'.$row['id_facultate'].'" selected="selected">'.$row['denumire'].'</option>';

				else 
					echo '
						<option value="'.$row['id_facultate'].'">'.$row['denumire'].'</option>';
			}
			close_pg_session($dbpg);

			echo 
			'
							</select>
			';

		}
	
		echo 
		'
					</td>
				</tr>
				<tr>
					<td>Nr. total de credite</td>
					<td>Valabil de la:</td>
					<td>Valabil pînă la:</td>
				</tr>
				<tr>
					<td><input type="text" name="nr_total_credite" value="'.$_NPSR["nr_total_credite"].'"></td>
					<td><input type="date" name="de_la" value="'.$_NPSR["de_la"].'"></td>
					<td><input type="date" name="pina_la" value="'.$_NPSR["pina_la"].'"></td>
				</tr>
				<tr>
					<td><input type="submit" value="Salvează"></tdf>
			</form>
			<form action="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii" method="POST">
					<td colspan=2 valign="top"><input type="submit" value="Renunţă"></tdf>
			</form>
				</tr>
			</table>
		';

		echo 'Informaţie unităţi de curs: 
		';
		echo '<a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'&nou_apc=1">Adaogă o unitate nouă.</a>
		';

		$sql = 
		"
			SELECT
				apc.id_asoc_ps_cod AS id_asoc_ps_cod,
				apc.id_plan_studii AS id_plan_studii,
				apc.cod AS cod,
				apc.id_an_de_studii AS id_an_de_studii,
				apc.id_semestru AS id_semestru,
				nads.cod AS cod_an_de_studii,
				nads.denumire AS denumire_an_de_studii,
				ns.cod AS cod_semestru,
				ns.denumire AS denumire_semestru
			FROM
				bdsiu.asoc_ps_cod AS apc
				INNER JOIN bdsiu.nom_an_de_studii AS nads ON apc.id_an_de_studii = nads.id_an_de_studii
				INNER JOIN bdsiu.nom_semestru AS ns ON apc.id_semestru = ns.id_semestru
			WHERE id_plan_studii = ".$_NPSR['id_plan_studii']."
			ORDER BY id_semestru, id_asoc_ps_cod
		";

	    $dbpg = start_pg_session($pg_connect,$nume_cont);
	    $result_apc = pg_query($dbpg, $sql);
	    close_pg_session($dbpg);

	    echo '
				<table border=1 style="border-collapse:collapse;" class="table table-bordered">
					<tr align="center">
						<td colspan=3>COD</td>
						<td>AN</td>
						<td>SEM</td>
					  	<td rowspan=2>Forma de evaluare</td>
					  	<td rowspan=2>Credite</td>
						<td colspan=5>Ore</td>
					</tr>
					<tr align="center">
						<td>UC</td>
						<td>M/C</td>
						<td>D</td>
						<td colspan=2>Denumire</td>
						<td>CD</td>
						<td>SI</td>
						<td>Curs</td>
						<td>Sem.</td>
						<td>Lab.</td>
					</tr>	    		
	    ';


	    while ($row_apc = pg_fetch_array($result_apc)) 
	    {
	    	echo 
	    	'
	    			<tr>
	    				<td colspan=3><b>'.$row_apc["cod"].'</b></td>
	    				<td>'.$row_apc["cod_an_de_studii"].'</td>
	    				<td>'.$row_apc["cod_semestru"].'</td>
	    				<td colspan=7 align="right"> 
							<a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'&id_asoc_ps_cod='.$row_apc["id_asoc_ps_cod"].'&add_apcm=1">AM</a> || 
							<a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'&id_asoc_ps_cod='.$row_apc["id_asoc_ps_cod"].'&new_apcm=1">CM</a>
	    				</td>
	    			</tr>
	    	';

			$sql = 
			"
				SELECT
					apcm.id_asoc_ps_cod_modul AS id_asoc_ps_cod_modul,
					apcm.id_modul AS id_modul,
					apcm.id_asoc_ps_cod AS id_asoc_ps_cod,
					apcm.id_forma_de_evaluare AS id_forma_de_evaluare,
					apcm.nr_credite AS nr_credire,
					nm.cod AS cod_modul,
					nm.denumire AS denumire_modul,
					nm.denumire_en AS denumire_en_modul,
					nfde.cod AS cod_forma_de_evaluare,
					nfde.denumire AS denumire_forma_de_evaluare
				FROM
					bdsiu.asoc_ps_cod_modul AS apcm
					INNER JOIN bdsiu.nom_module AS nm ON apcm.id_modul = nm.id_modul
					INNER JOIN bdsiu.nom_forma_de_evaluare AS nfde ON apcm.id_forma_de_evaluare = nfde.id_forma_de_evaluare
				WHERE id_asoc_ps_cod = ".$row_apc["id_asoc_ps_cod"]."
			";

		    $dbpg = start_pg_session($pg_connect,$nume_cont);
		    $result_apcm = pg_query($dbpg, $sql);
		    close_pg_session($dbpg);

		    while ($row_apcm = pg_fetch_array($result_apcm)) 
		    {
		    	echo '
		    		<tr>
		    			<td>&nbsp;</td>
		    			<td colspan=2>'.$row_apcm['cod_modul'].'
		    			<td colspan=2>'.$row_apcm['denumire_modul'].'</td>
		    			<td>'.$row_apcm['denumire_forma_de_evaluare'].'</td>
		    			<td>'.$row_apcm['nr_credire'].'</td>
		    			<td colspan=5 align="right"> 
							<a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR['id_plan_studii'].'&id_asoc_ps_cod_modul='.$row_apcm["id_asoc_ps_cod_modul"].'&add_dis=1">AD</a> 
		    			</td>
		    		</tr>
		    	';

				$sql = 
				"
					SELECT
						apmd.id_asoc_ps_modul_discipline AS id_asoc_ps_modul_discipline,
						apmd.id_disciplina AS id_disciplina,
						apmd.id_asoc_ps_cod_modul AS id_asoc_ps_cod_modul,
						apmd.nr_ore_contact_direct AS nr_ore_contact_direct,
						apmd.nr_ore_studiu_individual AS nr_ore_studiu_individual,
						apmd.nr_ore_curs AS nr_ore_curs,
						apmd.nr_ore_seminarii AS nr_ore_seminarii,
						apmd.nr_ore_laborator AS nr_ore_laborator,
						nd.cod AS cod_disciplina,
						nd.denumire AS denumire_disciplina
					FROM
						bdsiu.asoc_ps_modul_discipline AS apmd
						INNER JOIN bdsiu.nom_discipline AS nd ON apmd.id_disciplina = nd.id_disciplina
					WHERE id_asoc_ps_cod_modul = ".$row_apcm["id_asoc_ps_cod_modul"]."
				";

			    $dbpg = start_pg_session($pg_connect,$nume_cont);
			    $result_apmd = pg_query($dbpg, $sql);
			    close_pg_session($dbpg);
// 12 column
			    while ($row_apmd = pg_fetch_array($result_apmd)) 
			    {
			    	echo '
			    		<tr>
			    			<td>&nbsp;</td>
			    			<td>&nbsp;</td>
			    			<td>'.$row_apmd['cod_disciplina'].'</td>
			    			<td colspan=4>'.$row_apmd['denumire_disciplina'].'</td>
			    			<td>'.$row_apmd['nr_ore_contact_direct'].'</td>
			    			<td>'.$row_apmd['nr_ore_studiu_individual'].'</td>
			    			<td>'.$row_apmd['nr_ore_curs'].'</td>
			    			<td>'.$row_apmd['nr_ore_seminarii'].'</td>
			    			<td>'.$row_apmd['nr_ore_laborator'].'</td>
			    		</tr>
			    	';
			    }


		    }

	    }
	    echo '
	    		</table>
	    ';

	}

// modificare nom_plan_studii	
	else if(isset($_POST['modificare_ps']))
	{
		if ($_POST['de_la'] == "") $de_la = "null"; else $de_la = "'".$_POST["de_la"]."'";
		if ($_POST['pina_la'] == "") $pina_la = "null"; else $pina_la = "'".$_POST["pina_la"]."'";
	   
	    $dbpg = start_pg_session($pg_connect,$nume_cont);
	    $sql = "
	    	UPDATE bdsiu.nom_plan_studii 
	    		SET 
	    			nr_plan_cadru = '".$_POST['nr_plan_cadru']."', 
	    			data_plan_cadru = '".$_POST['data_plan_cadru']."', 
	    			denumire = '".$_POST['denumire']."', 
	    			id_specialitate = '".$_POST['id_specialitate']."', 
	    			id_facultate = '".$_POST['id_facultate']."', 
	    			nr_total_credite = '".$_POST['nr_total_credite']."', 
	    			de_la = ".$de_la.", 
	    			pina_la = ".$pina_la." 
	    		WHERE id_plan_studii = ".$_POST['id_plan_studii']."
	    ";
		pg_query($dbpg, $sql);
		close_pg_session($dbpg);

		echo '
			<script>
				<!--
				location.replace("'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_POST['id_plan_studii'].'");
				-->
			</script>
		';
	}

// afisare nom_plan_studii
	else 
	{
	    if(isset($_SESSION['id_facultate'])) 
		{
			$sql = 
			'
			SELECT
				nps.denumire AS denumire,
				nps.nr_plan_cadru AS nr_plan_studii,
				nps.data_plan_cadru AS data_plan_studii,
				ns.denumire AS denumire_specialitate,
				nf.denumire AS denumire_facultate,
				nps.id_plan_studii AS id_plan_studii,
				nps.id_specialitate AS id_specialitate,
				nps.id_facultate AS id_facultate,
				nps.nr_total_credite AS nr_total_credite,
				nps.de_la AS de_la,
				nps.pina_la AS pina_la
			FROM
				bdsiu.nom_plan_studii AS nps
				INNER JOIN bdsiu.nom_specialitate AS ns ON nps.id_specialitate = ns.id_specialitate
				INNER JOIN bdsiu.nom_facultate AS nf ON nps.id_facultate = nf.id_facultate
			WHERE id_facultate = '.$_SESSION["id_facultate"].'
			ORDER BY denumire, denumire_specialitate, denumire_facultate
			';
		}
		else
		{
			$sql = 
			'
			SELECT
				nps.denumire AS denumire,
				nps.nr_plan_cadru AS nr_plan_studii,
				nps.data_plan_cadru AS data_plan_studii,
				ns.cod AS cod_specialitate,
				ns.denumire AS denumire_specialitate,
				nf.denumire AS denumire_facultate,
				nps.id_plan_studii AS id_plan_studii,
				nps.id_specialitate AS id_specialitate,
				nps.id_facultate AS id_facultate,
				nps.nr_total_credite AS nr_total_credite,
				nps.de_la AS de_la,
				nps.pina_la AS pina_la
			FROM
				bdsiu.nom_plan_studii AS nps
				INNER JOIN bdsiu.nom_specialitate AS ns ON nps.id_specialitate = ns.id_specialitate
				INNER JOIN bdsiu.nom_facultate AS nf ON nps.id_facultate = nf.id_facultate
			ORDER BY denumire_facultate, denumire_specialitate, denumire
			';
		}

	    $rowmax = '0';

	    $dbpg = start_pg_session($pg_connect,$nume_cont);
	    $result = pg_query($dbpg, $sql);

	    while ($row = pg_fetch_array($result))
	    {
	        $rowmax ++;

			$_NPSR[$rowmax]['denumire'] = $row['denumire'];
			$_NPSR[$rowmax]['nr_plan_studii'] = $row['nr_plan_studii'];
			$_NPSR[$rowmax]['data_plan_studii'] = $row['data_plan_studii'];
			$_NPSR[$rowmax]['denumire_specialitate'] = $row['denumire_specialitate'];
			$_NPSR[$rowmax]['denumire_facultate'] = $row['denumire_facultate'];
			$_NPSR[$rowmax]['id_plan_studii'] = $row['id_plan_studii'];
			$_NPSR[$rowmax]['id_specialitate'] = $row['id_specialitate'];
			$_NPSR[$rowmax]['id_facultate'] = $row['id_facultate'];
			$_NPSR[$rowmax]['nr_total_credite'] = $row['nr_total_credite'];
			$_NPSR[$rowmax]['de_la'] = $row['de_la'];
			$_NPSR[$rowmax]['pina_la'] = $row['pina_la'];

	    }
	    close_pg_session($dbpg);

	    echo '
			<a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&n=new" class="btn btn-primary">Plan de studii nou</a></br></br>
	        <table class="table table-striped">
	            <tr>
	                <td>Nr.</td>
	                <td>Denumire</td>
	                <td>Nr.PS</td>
	                <td>Data PS</td>
	                <td>Specialitate</td>
	                <td>Facultate</td>
	            </td>
	    ';

	    $i = '0';

	    while ($i < $rowmax)
	    {
	        $i ++;
	        echo'
	            <tr>
	                <td>'.$i.'</td>
	                <td><a href="'.$server_url.'/includes/main_frame_sheet.php?a=nom_plan_studii&id_plan_studii='.$_NPSR[$i]['id_plan_studii'].'">'.$_NPSR[$i]['denumire'].'</a></td>
	                <td>'.$_NPSR[$i]['nr_plan_studii'].'</td>
	                <td>'.$_NPSR[$i]['data_plan_studii'].'</td>
	                <td>'.$_NPSR[$i]['denumire_specialitate'].'</td>
	                <td>'.$_NPSR[$i]['denumire_facultate'].'</td>
	            </td>
	        ';
	    }

	    echo '
	        </table>
	    ';
	}


	echo "</div>";
}
else 
{
echo 
'<html>
Login error!
</html>'; 
}

/*
// new action	
	else if(isset($_GET['any_get']))
	{
		echo "any action";
	}

*/

?>
