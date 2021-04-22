<?php
     include ("Lista.php");
     include ("conexionSQL.php");   
     $conn=sqlsrv_connect($server,$connectionInfo);
     if( $conn === false) {
         die( print_r( sqlsrv_errors(), true));
     }
     $sql = "select Fecha, Login, Numero, Mensaje, Landing, CampanaID FROM [sms_Samsung]";

     if (isset($_POST['agente']) && $_POST['agente'] != '' ) {
        $sql .= " WHERE Login LIKE '%".$_POST['agente']."%'";
    }
    if (isset($_POST['fecha1']) and $_POST['fecha1'] != '' ) {
        $fecha1 = $_POST['fecha1'];
        $sql.= " AND Fecha >= '".$fecha1."'";
    }
    if (isset($_POST['fecha2']) and $_POST['fecha2'] != '' ) {
        $fecha2 = $_POST['fecha2'];
        $sql .= " AND Fecha <= '".$fecha2."'";
    }
    $sql.= " order by Fecha desc";
    
    $stmt = sqlsrv_query( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
    
    
    $mensaje = "\xEF\xBB\xBFFecha;Hora;Login;Numero;Landing;Mensaje;CampanaID\n";
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {    
   
        $mensaje .=$row['Fecha']->format('Y-m-d').";";  
        $mensaje .= $row['Fecha']->format('H:i:s').";";    
        $mensaje .= $row['Login'].";";  
        $mensaje .= $row['Numero'].";";  
        $mensaje .= $row['Landing'].";";  
		$mensaje .= $row['Mensaje'].";";  
        $mensaje .=$row['CampanaID']."\n";   
    }     
   
    file_put_contents("temp.csv", $mensaje);
?>