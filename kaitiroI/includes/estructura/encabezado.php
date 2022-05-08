<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>encabezado</title>
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>	
</head>

<body>
	<section id="offer">
		<?php

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

	$sql1 = "SELECT
            COUNT(a.dispositivo) adispositivo
        FROM
            (
            SELECT
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
            1
        ) a
    WHERE
        valor = 1";
	$sql2 = "SELECT
            COUNT(a.dispositivo) bdispositivo
        FROM
            (
            SELECT
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
            1
        ) a
    WHERE
        valor = 0";
	$sql3 = "SELECT
            COUNT(a.dispositivo) cdispositivo
        FROM
            (
            SELECT
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
            1
        ) a";

	
if ($result = $conn->query($sql1)) {
    while ($row = $result->fetch_assoc()) {
        $row_encendido = $row["adispositivo"];     
    }
    $result->free();
if ($result=$conn->query($sql2)){
	while($row=$result->fetch_assoc()){
		$row_apagado = $row["bdispositivo"];
	}
	$result->free();
if ($result=$conn->query($sql3)){
	while($row=$result->fetch_assoc()){
		$row_contelar = $row["cdispositivo"];
	}
	$result->free();
	}
}
	
$capacidad = (($row_encendido)/$row_contelar)*100;


	echo 
		'<h2>' . " La ´´UCI´´ Está Tejiendo Al ".number_format((int)$capacidad,2,',','.')."% De Su Capacidad Total" . '</h2>'.
    	'<h3>' . " De ".$row_contelar." máquinas sensadas, hay ".$row_encendido." máquinas trabajando y ".$row_apagado." máquinas paradas" . '<h3>';
	
}

$conn->close();
?>
    
  </section>
	
<script>
$(document).ready(function() {
      var refreshId =  setInterval( function(){
    $('#offer').load('includes/estructura/encabezado.php');//actualizas el div
   }, 59999 );
});
</script>
	
</body>
</html>
