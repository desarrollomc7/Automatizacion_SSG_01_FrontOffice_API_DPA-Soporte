<?php
    include("conexion.php");
    header('Content-Type: text/html; charset=UTF-8'); 
    
    if (!($link=mysqli_connect($server,$user,$pass,$db)) ) {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");  
    
    $query = 'select * from samsung.asc ';
    $result = mysqli_query($link, $query);
    if( mysqli_num_rows($result) == 0 ) {
        echo "<p class='mensaje'>Error consultando base de datos</p>";
    } else {
        echo "<p class='mensaje'>";
        while ($row = mysqli_fetch_row($result)){   
            echo "<br>";  
            echo $row[0]." - ";
            echo $row[1]." - ";
            echo $row[2]." - ";
            echo $row[3]." - ";
            echo $row[4]." - ";
            echo $row[5]." - ";
            echo $row[6]." - ";
            echo $row[7]." - ";
            echo $row[8]." - ";
            echo $row[9]." - ";
            echo $row[10]." - ";
            echo $row[11];
        }
        echo "</p>";
    }
    echo "<br>";
?>