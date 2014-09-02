<div>
<?php

if(isset($_POST['id_utilizator'])) 
{
	$dbpg = start_pg_session($pg_connect,$nume_cont);

	$sql = "UPDATE bdsiu.utilizatori_sistem SET parola='".$_POST['parola1']."', nume_utilizator='".$_POST['nume_utilizator']."', prenume_utilizator='".$_POST['prenume_utilizator']."', adresa_mail='".$_POST['adresa_mail']."' WHERE (id_utilizator='".$_POST['id_utilizator']."')"; 
	pg_query($dbpg, $sql);

	close_pg_session($dbpg);
}


$dbpg = start_pg_session($pg_connect,$nume_cont);

$sql="SELECT * FROM bdsiu.utilizatori_sistem WHERE bdsiu.utilizatori_sistem.id_utilizator = '".$id_utilizator."'"; 
$result = pg_query($dbpg, $sql);
$row = pg_fetch_array($result);
$_ACR['id_utilizator'] = $row['id_utilizator'];
$_ACR['nume_cont'] = $row['nume_cont'];
$_ACR['parola'] = $row['parola'];
$_ACR['rol_asociat'] = $row['rol_asociat'];
$_ACR['nume_utilizator'] = $row['nume_utilizator'];
$_ACR['prenume_utilizator'] = $row['prenume_utilizator'];
$_ACR['adresa_mail'] = $row['adresa_mail'];
$_ACR['telefon'] = $row['telefon'];
$_ACR['de_la'] = $row['de_la'];
$_ACR['pina_la'] = $row['pina_la'];


$sql="SELECT * FROM bdsiu.nom_rol_utilizator WHERE bdsiu.nom_rol_utilizator.id_nom_rol_utilizator = '".$_ACR['rol_asociat']."'"; 
$result = pg_query($dbpg, $sql);
$row = pg_fetch_array($result);
$_ACR['denumire_rol_asociat'] = $row['rol'];

close_pg_session($dbpg);

?>

<script type="text/javascript" src="<?php echo $server_url; ?>/functions/passtest.js"></script>

	<form action="<?php echo $server_url; ?>/includes/main_frame_sheet.php?a=administrare_cont" method="POST">
	<input type="hidden" name="id_utilizator" value="<?php echo $_ACR['id_utilizator'];?>">
<table>
	<tr>
		<td>Nume cont:</tdf>
		<td><input type="text" name="nume_cont" value="<?php echo $_ACR['nume_cont']; ?>" readonly></tdf>
	</tr>
	<tr>
		<td>Parola:</tdf>
		<td><input type="password" name="parola" id="pass1" value="<?php echo $_ACR['parola']; ?>"></tdf>
	</tr>
	<tr>
		<td>Confirmă parola:</tdf>
		<td><input type="password" name="parola1" id="pass2" value="<?php echo $_ACR['parola']; ?>" onkeyup="checkPass(); return false;"></tdf>
	</tr>
	<tr>
		<td>Rol asociat:</tdf>
		<td><input type="text" name="denumire_rol_asociat" value="<?php echo $_ACR['denumire_rol_asociat']; ?>" readonly></tdf>
	</tr>
	<tr>
		<td>Nume:</tdf>
		<td><input type="text" name="nume_utilizator" value="<?php echo $_ACR['nume_utilizator']; ?>"></tdf>
	</tr>
	<tr>
		<td>Prenume:</tdf>
		<td><input type="text" name="prenume_utilizator" value="<?php echo $_ACR['prenume_utilizator']; ?>"></tdf>
	</tr>
	<tr>
		<td>Adresa e-mail:</tdf>
		<td><input type="email" name="adresa_mail" value="<?php echo $_ACR['adresa_mail']; ?>"></tdf>
	</tr>
	<tr>
		<td>Cont valabil de la:</tdf>
		<td><input type="date" name="de_la" value="<?php echo $_ACR['de_la']; ?>" readonly></tdf>
	</tr>
	<tr>
		<td>Cont valabil pînă la:</tdf>
		<td><input type="date" name="pina_la" value="<?php echo $_ACR['pina_la']; ?>" readonly></tdf>
	</tr>
	<tr>
		<td colspan=2><input type="submit" value="Schimbă datele"></tdf>
	</tr>

</table>
</form>

</div>