<!DOCTYPE html>
<html><body>
<?php

$servername = "localhost";

$dbname = "cksgroup_Kaitiro";
$username = "cksgroup_admin";
$password = "Cks+0002";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT contador, tiempo, valor, dispositivo FROM registros ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>Contador</td> 
        <td>Fecha y Hora</td> 
        <td>Telar</td> 
        <td>Estado</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_contador = $row["contador"];
        $row_tiempo = $row["tiempo"];
        $row_dispositivo = $row["dispositivo"];
        $row_valor = $row["valor"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        $row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 5 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_contador . '</td> 
                <td>' . $row_tiempo . '</td> 
                <td>' . $row_dispositivo . '</td> 
                <td>' . $row_valor . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>
