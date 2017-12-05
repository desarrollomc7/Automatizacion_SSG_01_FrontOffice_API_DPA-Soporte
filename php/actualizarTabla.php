<?php
    include ("Lista.php");
    include ("conexion.php");
       
    if (!($link=mysqli_connect($server,$user,$pass,$db)))  
    {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");
    $query = "SELECT t.fechatransaccion, o.estado, o.distrito2, t.modelo, t.sintoma_cat1, t.sintoma_cat2, t.sintoma_cat3, t.resolucion, t.estado, t.estado_razon, t.almacen, o.usuario, t.usuariowindows, o.telefonocelular, t.numeroidentificacion_cliente, o.idpedido, t.prototipo, o.serviciotecnicoautorizado_id FROM (SELECT s.serviciotecnicoautorizado_id ,s.idpedido, s.solicitud_fecha, s.solicitud_tiempo, c.estado, c.distrito2,CONCAT(nombre, ' ', apellido) AS usuario, c.telefonocelular, c.numeroidentificacion FROM cliente c LEFT JOIN servicerequest s ON c.numeroidentificacion = s.numeroidentificacion_cliente) AS o , transaccion t where o.numeroidentificacion = t.numeroidentificacion_cliente";

    if (isset($_POST['departamento']) and $_POST['departamento'] != '' ) {
        $departamentos = $_POST['departamento'];
        $query .= " AND (";
        foreach ( $departamentos as $valor ){
            $query .= " o.estado = '".$valor."' OR";
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    if (isset($_POST['ciudad']) and $_POST['ciudad'] != '' ) {
        $ciudades = $_POST['ciudad'];
        $query .= " AND (";
        foreach ( $ciudades as $valor ){
            $query .= " o.distrito2 = '".$valor."' OR";
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    if (isset($_POST['tipo1']) and $_POST['tipo1'] != '' ) {
        $tipos = $_POST['tipo1'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            if( $valor == "*Sin datos"){
                $query .= " t.sintoma_cat1 = '' OR";
            } else {
                $query .= " t.sintoma_cat1 = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    
    if (isset($_POST['tipo3']) and $_POST['tipo3'] != '' ) {
        $tipos = $_POST['tipo3'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            
            if( $valor == "*Sin datos"){
                $query .= " t.sintoma_cat3 = '' OR";
            } else {
                $query .= " t.sintoma_cat3 = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    
    if (isset($_POST['almacen']) and $_POST['almacen'] != '' ) {
        
        $tipos = $_POST['almacen'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            
            if( $valor == "*Sin datos"){
                $query .= " t.almacen = '' OR";
            } else {
                $query .= " t.almacen = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }

    if (isset($_POST['agente']) ) {
        $query .= " AND t.usuariowindows LIKE '%".$_POST['agente']."%'";
    }

    if (isset($_POST['cedula']) ) {
        $query .= " AND t.numeroidentificacion_cliente LIKE '%".$_POST['cedula']."%'";
    }

    if (isset($_POST['estado']) and $_POST['estado'] != '' ) {
        $tipos = $_POST['estado'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            if( $valor == "*Sin datos"){
                $query .= " t.estado = '' OR";
            } else {
                $query .= " t.estado = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    
    if (isset($_POST['nombre']) and $_POST['nombre'] != '') {
        $query .= " AND o.usuario LIKE '%".$_POST['nombre']."%'";
    }
    if (isset($_POST['fecha1']) and $_POST['fecha1'] != '' ) {
        $fecha1 = $_POST['fecha1'];
        $query .= " AND fechatransaccion >= '".$fecha1."'";
    }
    if (isset($_POST['fecha2']) and $_POST['fecha2'] != '' ) {
        $fecha2 = $_POST['fecha2'];
        $query .= " AND fechatransaccion <= '".$fecha2."'";
    }
    if (!empty($_POST['departamento']) ) {
        if (!isset($_POST['nombre']) ) {
            $query .= " COLLATE utf8_bin";
        }
    }
    $query .= " ORDER BY t.fechatransaccion desc";
            
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_row($result)){   
        echo "<tr>";  
        vacio( substr($row[0], 0, 10) );  
        vacio( substr($row[0], -8) );  
        vacio( $row[17] );  
        vacio( $row[16] );  
        vacio( $row[15] );  
        vacio( $row[3] );  
        lista( $row[3] );
        vacio( $row[4] );  
        vacio( $row[5] );  
        vacio( $row[6] );  
        vacio( $row[7] );  
        vacio( $row[8] );  
        vacio( $row[9] );  
        vacio( $row[10] );  
        vacio( $row[12] );  
        vacio( $row[11] );  
        vacio( $row[14] );  
        vacio( $row[13] );  
        vacio( $row[2] );
        vacio( $row[1] );  
        echo "</tr>";  
        // vacios: sin datos
    }     

    // SELECT s.solicitud_fecha, s.solicitud_tiempo, estado, distrito2, CONCAT(apellido, ' ', nombre) AS usuario, c.telefonocelular FROM cliente c, servicerequest s WHERE c.numeroidentificacion = s.numeroidentificacion_cliente;
?>