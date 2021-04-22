<?php
    include ("Lista.php");
    include ("conexion.php");   
    if (!($link=mysqli_connect($server,$user,$pass,$db)))  
    {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");
    $query = "select t.login, t.clienteIdentificacion, t.horaInicial, t.horaFinal, TIMEDIFF(t.horaFinal,t.horaInicial) AS `TiempoTotal`, t.fecha, c.numeroidentificacion from samsung.tiempoLlamada t LEFT JOIN samsung.cliente c ON c.id = t.clienteIdentificacion ";
    
    if (isset($_POST['agente']) ) {
        $query .= " WHERE login LIKE '%".$_POST['agente']."%'";
    }

    if (isset($_POST['cedula']) ) {
        $query .= " AND clienteIdentificacion LIKE '%".$_POST['cedula']."%'";
    }

    if (isset($_POST['fecha1']) and $_POST['fecha1'] != '' ) {
        $fecha1 = $_POST['fecha1'];
        $query .= " AND fecha >= '".$fecha1."'";
    }
    if (isset($_POST['fecha2']) and $_POST['fecha2'] != '' ) {
        $fecha2 = $_POST['fecha2'];
        $query .= " AND fecha <= '".$fecha2."'";
    }
    $query .= " order by t.fecha desc, t.horainicial desc LIMIT 250";
    // echo $query;
    $result = mysqli_query($link, $query);

    echo "<thead><tr><th>Fecha</th><th>Tiempo Total</th><th>Cliente</th><th>Cédula</th><th>Agente</th><th>Hora Inicial</th><th>Hora Final</th></tr></thead><tbody>";
        
    while ($row = mysqli_fetch_row($result)){   
        echo "<tr>";  
        vacio( $row[5] );  
        vacio( $row[4] );  
        vacio( $row[1] );  
        vacio( $row[6] );  
        vacio( $row[0] );  
        lista( $row[2] );
        vacio( $row[3] );  
        echo "</tr>";  
        // vacios: sin datos
    }     
    echo "</tbody>";
?>