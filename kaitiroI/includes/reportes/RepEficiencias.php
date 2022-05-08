<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tabla Eficiencias de Telares</title>
</head>
<body>
	
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

	$sql = "SELECT
    B.dispositivo AS dispositivo,
    B.valor AS valor,
    B.tiempo AS tiempo,
    C.eficiencia AS eficiencia,
    D.efturno3 AS efturno3,
    E.efturno1 AS efturno1,
    F.efturno2 AS efturno2,
    G.acturno1 AS acturno1,
    H.acturno2 AS acturno2,
    I.acturno3 AS acturno3
FROM
    (
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
    ) B
LEFT JOIN(
    SELECT
        dispositivo,
        ((SUM(valor) / 1440) * 100) AS eficiencia
    FROM
        (
        SELECT
            dispositivo,
            tiempo,
            valor
        FROM
            (
            SELECT
                tiempo,
                dispositivo,
                valor
            FROM
                registros
            WHERE
                tiempo BETWEEN CURRENT_TIMESTAMP - INTERVAL 24 HOUR AND CURRENT_TIMESTAMP
        ) ultdia
    GROUP BY
        dispositivo,
        tiempo,
        valor
    ) dia
GROUP BY
    dispositivo
) C
ON
    B.dispositivo = C.dispositivo
LEFT JOIN(
    SELECT
        dispositivo,
        ((SUM(valor) / 480) * 100) AS efturno3
    FROM
        (
        SELECT
            dispositivo,
            tiempo,
            valor
        FROM
            (
            SELECT
                tiempo,
                dispositivo,
                valor
            FROM
                registros
            WHERE
                tiempo BETWEEN(
                SELECT
                    (
                        DATE_SUB(
                            CONCAT(CURDATE(), ' 22:00:00'),
                            INTERVAL 1 DAY)
                        ) AS stturno3
                    ) AND(
                    SELECT
                        (CONCAT(CURDATE(), ' 05:59:59')) AS fnturno3)
                ) ultdia
            GROUP BY
                dispositivo,
                tiempo,
                valor
            ) dia
        GROUP BY
            dispositivo
        ) D
    ON
        D.dispositivo = B.dispositivo
    LEFT JOIN(
        SELECT
            dispositivo,
            ((SUM(valor) / 480) * 100) AS efturno1
        FROM
            (
            SELECT
                dispositivo,
                tiempo,
                valor
            FROM
                (
                SELECT
                    tiempo,
                    dispositivo,
                    valor
                FROM
                    registros
                WHERE
                    tiempo BETWEEN(
                    SELECT
                        (CONCAT(CURDATE(), ' 06:00:00')) AS stturno1) AND(
                        SELECT
                            (CONCAT(CURDATE(), ' 13:59:59')) AS fnturno1)
                    ) ultdia
                GROUP BY
                    dispositivo,
                    tiempo,
                    valor
                ) dia
            GROUP BY
                dispositivo
            ) E
        ON
            E.dispositivo = B.dispositivo
        LEFT JOIN(
            SELECT
                dispositivo,
                ((SUM(valor) / 480) * 100) AS efturno2
            FROM
                (
                SELECT
                    dispositivo,
                    tiempo,
                    valor
                FROM
                    (
                    SELECT
                        tiempo,
                        dispositivo,
                        valor
                    FROM
                        registros
                    WHERE
                        tiempo BETWEEN(
                        SELECT
                            (CONCAT(CURDATE(), ' 14:00:00')) AS stturno2) AND(
                            SELECT
                                (CONCAT(CURDATE(), ' 21:59:59')) AS fnturno2)
                        ) ultdia
                    GROUP BY
                        dispositivo,
                        tiempo,
                        valor
                    ) dia
                GROUP BY
                    dispositivo
                ) F
            ON
                F.dispositivo = B.dispositivo
            LEFT JOIN(
                SELECT
                    dispositivo,
                    (
                        (
                            SUM(valor) / COUNT(dispositivo)
                        ) * 100
                    ) AS acturno1
                FROM
                    (
                    SELECT
                        dispositivo,
                        tiempo,
                        valor
                    FROM
                        (
                        SELECT
                            tiempo,
                            dispositivo,
                            valor
                        FROM
                            registros
                        WHERE
                            tiempo BETWEEN(
                            SELECT
                                (CONCAT(CURDATE(), ' 06:00:00')) AS stturno1) AND(
                                SELECT
                                    (CONCAT(CURDATE(), ' 13:59:59')) AS fnturno1)
                            ) ultdia
                        GROUP BY
                            dispositivo,
                            tiempo,
                            valor
                        ) dia
                    GROUP BY
                        dispositivo
                    ) G
                ON
                    G.dispositivo = B.dispositivo
                LEFT JOIN(
                    SELECT
                        dispositivo,
                        (
                            (SUM(valor) / COUNT(valor)) * 100
                        ) AS acturno2
                    FROM
                        (
                        SELECT
                            dispositivo,
                            tiempo,
                            valor
                        FROM
                            (
                            SELECT
                                tiempo,
                                dispositivo,
                                valor
                            FROM
                                registros
                            WHERE
                                tiempo BETWEEN(
                                SELECT
                                    (CONCAT(CURDATE(), ' 14:00:00')) AS stturno2) AND(
                                    SELECT
                                        (CONCAT(CURDATE(), ' 21:59:59')) AS fnturno2)
                                ) ultdia
                            GROUP BY
                                dispositivo,
                                tiempo,
                                valor
                            ) dia
                        GROUP BY
                            dispositivo
                        ) H
                    ON
                        H.dispositivo = B.dispositivo
                    LEFT JOIN(
                        SELECT
                            dispositivo,
                            (
                                (SUM(valor) / COUNT(valor)) * 100
                            ) AS acturno3
                        FROM
                            (
                            SELECT
                                dispositivo,
                                tiempo,
                                valor
                            FROM
                                (
                                SELECT
                                    tiempo,
                                    dispositivo,
                                    valor
                                FROM
                                    registros
                                WHERE
                                    tiempo BETWEEN(
                                    SELECT
                                        (
                                            DATE_SUB(
                                                CONCAT(CURDATE(), ' 22:00:00'),
                                                INTERVAL 1 DAY)
                                            ) AS stturno3
                                        ) AND(
                                        SELECT
                                            (CONCAT(CURDATE(), ' 05:59:59')) AS fnturno3)
                                    ) ultdia
                                GROUP BY
                                    dispositivo,
                                    tiempo,
                                    valor
                                ) dia
                            GROUP BY
                                dispositivo
                            ) I
                        ON
                            I.dispositivo = B.dispositivo
                        )
						ORDER BY dispositivo"; //Sentencia eficiencia total
	
echo '<table class="telarescx" border="1" cellspacing="5" cellpadding="5">
      <tr> 
	  	<td>'. "<img src= images/blue.png />".'</td>
        <td>Maquina</td> 
        <td>Ultima Actualizacion</td>
        <td>Eficiencia Ultimo dia</td>
		<td>Eficiencia Turno Actual</td>
        <td>Eficiencia Turno 1</td>
        <td>Eficiencia Turno 2</td>
        <td>Eficiencia Turno 3</td>
      </tr>';
	
$turnoAct='0';
$hora_actual = date("H:i:s", strtotime("$hora_actual - 5 hours"));
$inturno1 = date("H:i:s", strtotime("06:00"));
$inturno2 = date("H:i:s", strtotime("14:00"));
$inturno3 = date("H:i:s", strtotime("22:00"));
$outturno1 = date("H:i:s", strtotime("13:59:59"));
$outturno2 = date("H:i:s", strtotime("21:59:59"));
$outturno3 = date("H:i:s", strtotime("05:59:59"));
$startday = date("H:i:s", strtotime("00:00:00"));
$endday = date("H:i:s", strtotime("23:59:59"));
	
	
if($hora_actual>=$inturno1 && $hora_actual<=$outturno1){
	$turnoAct='1';
} elseif($hora_actual>=$inturno2 && $hora_actual<=$outturno2){
	$turnoAct='2';
} elseif (($hora_actual>=$inturno3 && $hora_actual<=$endday) || ($hora_actual>=$startday && $hora_actual<=$outturno3)) {
	$turnoAct='3';
}
	
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_tiempo = $row["tiempo"];
        $row_dispositivo = $row["dispositivo"];
        $row_valor = $row["valor"];
        $row_momento = date("M-d/Y h:i:a", strtotime("$row_tiempo - 0 hours"));
		
	if ($row_valor['valor']=='1'){
	$row_estado="Trabajando" and $imageStatus = "images/green.png";
	
				  
} 	else if ($row_valor['valor']=='0') {
	$row_estado="Parado" and $imageStatus = 'images/red.png';
}
		
		$row_eficienciaDia = $row["eficiencia"];
		
	if($row_eficienciaDia=="" or $row_eficienciaDia==''){
		$row_efdia="0";
	}
		else {
			$row_efdia=$row_eficienciaDia;
		}
		$row_eficienciaTurno3 =$row["efturno3"];
	if($row_eficienciaTurno3=="" or $row_eficienciaTurno3==''){
		$row_eft3= '0';
	}
		else {
			$row_eft3=$row_eficienciaTurno3;
		}
		
	$row_eficienciaTurno1 =$row["efturno1"];
	if($row_eficienciaTurno1=="" or $row_eficienciaTurno1==''){
		$row_eft1= '0';
	}
		else {
			$row_eft1=$row_eficienciaTurno1;
		}
	$row_eficienciaTurno2 =$row["efturno2"];
	if($row_eficienciaTurno2=="" or $row_eficienciaTurno2==''){
		$row_eft2= '0';
	}
		else {
			$row_eft2=$row_eficienciaTurno2;
		}
		
	if ($turnoAct=='1'){ $row_eficienciaTurnoAct=$row["acturno1"];
} elseif ($turnoAct=='2'){ $row_eficienciaTurnoAct=$row["acturno2"];
} elseif ($turnoAct=='3'){ $row_eficienciaTurnoAct=$row["acturno3"];
}
	
		
		echo '<tr> 
				<td>'. "<img src='".$imageStatus."' />".'</td>
                <td>' . "Telar : " . $row_dispositivo . '</td> 
                <td>' . "Fecha y Hora: " . $row_momento . '</td>
                <td>' . "Eficiencia: " . $row_efdia . "%" . '</td> 
                <td>' . "Estado: " . $row_eficienciaTurnoAct . "%" . '</td> 
                <td>' . "Eficiencia: " . $row_eft1 .  "%" .'</td> 
                <td>' . "Eficiencia: " . $row_eft2 .  "%" .'</td> 
                <td>' . "Eficiencia: " . $row_eft3 .  "%" .'</td>
              </tr>';
		

    }
    $result->free();
	}
	
$conn->close();
?>
</body>
</html>