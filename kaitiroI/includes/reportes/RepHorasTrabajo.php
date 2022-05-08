<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tabla Horas Trabajadas De Los Telares</title>
</head>
<body>
	
<?php

//$host="201.184.240.242";
//$port=3415;
//$socket="";
//$user="admin";
//$password="Cks+002";
//$dbname="kaitiro";
	
$servername = "localhost";
$dbname = "kaitiro";
$username = "admin";
$password = "Cks+0002";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

	$sql = "SELECT
    B.dispositivo AS dispositivo,
    B.valor AS valor,
    B.atiempo AS atiempo,
    C.btiempo AS btiempo,
    D.horasTrabajo AS horasTrabajo
FROM
    (
    SELECT
        t1.dispositivo,
        registros.valor,
        t1.atiempo
    FROM
        (
        SELECT
            dispositivo,
            MAX(tiempo) atiempo
        FROM
            registros
        GROUP BY
            dispositivo
    ) t1
INNER JOIN registros ON t1.dispositivo = registros.dispositivo AND t1.atiempo = registros.tiempo
ORDER BY
    1
) B
LEFT JOIN(
    SELECT
        t1.dispositivo,
        registros.valor,
        t1.btiempo
    FROM
        (
        SELECT
            dispositivo,
            MIN(tiempo) btiempo
        FROM
            registros
        GROUP BY
            dispositivo
    ) t1
INNER JOIN registros ON t1.dispositivo = registros.dispositivo AND t1.btiempo = registros.tiempo
ORDER BY
    1
) C
ON
    B.dispositivo = C.dispositivo
LEFT JOIN(
    SELECT
        dispositivo,
        (SUM(valor)) / 60 AS horasTrabajo
    FROM
        registros
    GROUP BY
        dispositivo
) D
ON
    B.dispositivo = D.dispositivo
ORDER BY
    dispositivo"; //Sentencia De Horas de Trabajo Acumuladas desde el primer registro en la base de datos
	
echo '<table class="telarescx" border="1" cellspacing="5" cellpadding="5">
      <tr> 
	  	<td>'. "<img src= images/blue.png />".'</td>
        <td>Maquina</td> 
        <td>Priemra Actualizacion</td> 
        <td>Ultima Actualizacion</td>
        <td>Horas de Funcionamiento Acumuladas</td>
      </tr>';
	
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_tiempoactual = $row["atiempo"];
		$row_tiempoinicio = $row["btiempo"];
        $row_dispositivo = $row["dispositivo"];
        $row_valor = $row["valor"];
        $row_momentoinicio = date("M-d/Y h:i:a", strtotime("$row_tiempoinicio - 0 hours"));
        $row_momentoactual = date("M-d/Y h:i:a", strtotime("$row_tiempoactual - 0 hours"));
		
	if ($row_valor['valor']=='1'){
	$imageStatus = "images/green.png";
	
				  
} 	else if ($row_valor['valor']=='0') {
	$imageStatus = 'images/red.png';
}

    $row_horasTrabajo = $row["horasTrabajo"];
		
		echo '<tr> 
				<td>'. "<img src='".$imageStatus."' />".'</td>
                <td>' . "Telar : " . $row_dispositivo . '</td> 
                <td>' . "Fecha y Hora: " . $row_momentoinicio . '</td>
                <td>' . "Fecha y Hora: " . $row_momentoactual . '</td>
                <td>' . "Horas de Trabajo: " . $row_horasTrabajo . '</td>
              </tr>';	
		
	}
	$result ->free();
}
	


$conn->close();
?>
</body>
</html>