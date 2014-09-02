<?php
if(isset($_SESSION['id_utilizator']))
{
	echo "<div>";

	echo "lista profesorilor";

	echo "</div>";
}
else 
{
echo 
'<html>
Login error!
</html>'; 
}
?>
