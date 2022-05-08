<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tabla Telares</title>
	
	
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>	


	
</head>
<body>
	
<?php

$host="201.184.240.242:3415";
$port=3306;
$socket="";
$user="Admin";
$password="Cks+002";
$dbname="kaitiro";
	
//$servername = "192.168.0.15";
//$dbname = "uckscomn_Kaitiro";
//$username = "uckscomn_admin";
//$password = "Cks+0002";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

	$sql = "SELECT
    t1.dispositivo,
    registros.valor,
    t1.tiempo
FROM
    (
    SELECT
        dispositivo,
        MAX(tiempo) tiempo
    FROM
        registros
    GROUP BY
        dispositivo
) t1
INNER JOIN registros ON t1.dispositivo = registros.dispositivo AND t1.tiempo = registros.tiempo
ORDER BY
    1";
	
echo '<table class="telarescx" border="1" cellspacing="5" cellpadding="5">
      <tr> 
	  	<td>'. "<img src= images/blue.png />".'</td>
        <td>Maquina</td> 
        <td>Ultima Actualizacion</td> 
        <td>Estado</td>
      </tr>';
	
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_contador = $row["contador"];
        $row_tiempo = $row["tiempo"];
        $row_dispositivo = $row["dispositivo"];
        $row_valor = $row["valor"];
        $row_momento = date("M-d/Y h:i:a", strtotime("$row_tiempo - 0 hours"));
		
		$row_lastupdate = new DateTime("$row_tiempo + 5 hours");//fecha inicial
		$row_ahora = new DateTime(date("d-m-Y H:i:00",localtime()));//fecha de cierre

		$row_desconexion = $row_lastupdate ->diff($row_ahora);

		$row_diferencia=$row_desconexion->format('%i');
		

if ($row_diferencia > '3'){
	$row_estado="Desconectado" and $imageStatus ="images/yellow.png";
	
} else if ($row_valor['valor']=='1'){
	$row_estado="Trabajando" and $imageStatus = "images/green.png";
	
				  
} else if ($row_valor['valor']=='0') {
	$row_estado="Parado" and $imageStatus = 'images/red.png';
}

	echo '<tr> 
				<td>'. "<img src='".$imageStatus."' />".'</td>
                <td>' . "Telar : " . $row_dispositivo . '</td> 
                <td>' . "Fecha y Hora: " . $row_momento . '</td> 
                <td>' . "Estado: " . $row_estado . '</td>
              </tr>';
		
        
    }
    $result->free();
	
	
}

$conn->close();
?>

	
	<script>
$(document).ready(function() {
      var refreshId =  setInterval( function(){
    $('#TablaTelares').load('includes/reportes/TelaresVivoTest.php');//actualizas el div
   }, 59999 );
});

</script>
		
	
</body>
</html>