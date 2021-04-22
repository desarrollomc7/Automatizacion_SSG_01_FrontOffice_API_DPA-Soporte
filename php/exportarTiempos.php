<?php
    include ("ListaExport.php");
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
    $query .= " order by t.fecha desc, t.horainicial desc";
    // echo $query;
    $result = mysqli_query($link, $query);

    $mensaje = "\xEF\xBB\xBFFecha;Tiempo Total;Cliente;Cédula;Agente;Hora Inicial;Hora Final\n";
        
    while ($row = mysqli_fetch_row($result)){     
        $mensaje .= vacio( $row[5] ).";";  
        $mensaje .= vacio( $row[4] ).";";  
        $mensaje .= vacio( $row[1] ).";";  
        $mensaje .= vacio( $row[6] ).";";  
        $mensaje .= vacio( $row[0] ).";";  
        $mensaje .= vacio( $row[2] ).";";
        $mensaje .= vacio( $row[3] )."\n";  
    }     
    file_put_contents("temp.csv", $mensaje);
?>