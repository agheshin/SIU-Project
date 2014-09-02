<?php
if(isset($_SESSION['id_utilizator']))
{
	echo "<div>";

	echo "Plan cadru actions";

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
