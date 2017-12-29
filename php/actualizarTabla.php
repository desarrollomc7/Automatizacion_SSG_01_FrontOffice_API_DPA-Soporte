<?php
    include ("Lista.php");
    include ("conexion.php");   
    if (!($link=mysqli_connect($server,$user,$pass,$db)))  
    {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");
    // $query = "SELECT t.fechatransaccion, o.estado, o.distrito2, t.modelo, t.sintoma_cat1, t.sintoma_cat2, t.sintoma_cat3, t.resolucion, t.estado, t.estado_razon, t.almacen, o.usuario, t.usuariowindows, o.telefonocelular, t.numeroidentificacion_cliente, o.idpedido, t.prototipo, o.serviciotecnicoautorizado_id FROM (SELECT s.serviciotecnicoautorizado_id ,s.idpedido, s.solicitud_fecha, s.solicitud_tiempo, c.estado, c.distrito2,CONCAT(nombre, ' ', apellido) AS usuario, c.telefonocelular, c.numeroidentificacion FROM cliente c LEFT JOIN servicerequest s ON c.numeroidentificacion = s.numeroidentificacion_cliente) AS o , transaccion t where o.numeroidentificacion = t.numeroidentificacion_cliente";
    $query = "select o.fechatransaccion, c.estado, c.distrito2, o.modelo, o.sintoma_cat1, o.sintoma_cat2, o.sintoma_cat3, o.resolucion, o.estado, o.estado_razon, o.almacen, CONCAT(c.nombre, ' ', c.apellido) AS usuario, o.usuariowindows, c.telefonocelular, o.numeroidentificacion_cliente, o.idpedido, o.prototipo, o.serviciotecnicoautorizado_id, o.version from (select t.fechatransaccion, t.modelo, t.sintoma_cat1, t.sintoma_cat2, t.sintoma_cat3, t.resolucion, t.estado, t.estado_razon, t.almacen, t.usuariowindows, t.numeroidentificacion_cliente, s.idpedido, t.prototipo, s.serviciotecnicoautorizado_id, s.version from  transaccion t LEFT JOIN servicerequest s ON t.idtransaccion = s.numerotransaccion_transaccion ) AS o, cliente c where o.numeroidentificacion_cliente = c.numeroidentificacion";

    if (isset($_POST['departamento']) and $_POST['departamento'] != '' ) {
        $departamentos = $_POST['departamento'];
        $query .= " AND (";
        foreach ( $departamentos as $valor ){
            $query .= " c.estado = '".$valor."' OR";
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    if (isset($_POST['ciudad']) and $_POST['ciudad'] != '' ) {
        $ciudades = $_POST['ciudad'];
        $query .= " AND (";
        foreach ( $ciudades as $valor ){
            $query .= " c.distrito2 = '".$valor."' OR";
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    if (isset($_POST['tipo1']) and $_POST['tipo1'] != '' ) {
        $tipos = $_POST['tipo1'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            if( $valor == "*Sin datos"){
                $query .= " o.sintoma_cat1 = '' OR";
            } else {
                $query .= " o.sintoma_cat1 = '".$valor."' OR";
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
                $query .= " o.sintoma_cat3 = '' OR";
            } else {
                $query .= " o.sintoma_cat3 = '".$valor."' OR";
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
                $query .= " o.almacen = '' OR";
            } else {
                $query .= " o.almacen = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }

    if (isset($_POST['agente']) ) {
        $query .= " AND o.usuariowindows LIKE '%".$_POST['agente']."%'";
    }

    if (isset($_POST['cedula']) ) {
        $query .= " AND o.numeroidentificacion_cliente LIKE '%".$_POST['cedula']."%'";
    }

    if (isset($_POST['estado']) and $_POST['estado'] != '' ) {
        $tipos = $_POST['estado'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            if( $valor == "*Sin datos"){
                $query .= " o.estado = '' OR";
            } else {
                $query .= " o.estado = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    
    if (isset($_POST['nombre']) and $_POST['nombre'] != '') {
        $query .= " AND c.usuario LIKE '%".$_POST['nombre']."%'";
    }
    if (isset($_POST['fecha1']) and $_POST['fecha1'] != '' ) {
        $fecha1 = $_POST['fecha1'];
        $query .= " AND fechatransaccion >= '".$fecha1."'";
    }
    if (isset($_POST['fecha2']) and $_POST['fecha2'] != '' ) {
        $fecha2 = $_POST['fecha2'];
        $query .= " AND fechatransaccion <= '".$fecha2."'";
    }
    if ( isset($_POST['linea']) ) {
        $linea = $_POST['linea'];
        if( $linea == 'DTV' )
            $query .= " AND o.modelo LIKE 'UN%' AND (o.modelo NOT LIKE 'UNK%' OR o.modelo = 'UNKNOWN VDE_LED' OR o.modelo = 'UNKNOWN VDE_LCD')";
        else if( $linea == 'II' )
            $query .= " AND o.sintoma_cat1 = 'Instalación'";
        else if( $linea == 'IH' )
            $query .= " AND (o.sintoma_cat1 != 'Instalación' AND o.modelo != 'UNKNOWN VDE_LED' AND o.modelo != 'UNKNOWN VDE_LCD' AND o.modelo != 'UNKNOWN HHP_HHP' AND o.modelo NOT LIKE 'GT-%' AND o.modelo NOT LIKE 'SGH-%' AND o.modelo NOT LIKE 'SM-%') AND o.modelo NOT REGEXP 'UN[0-9]'";
        else if( $linea == 'HHP' )
            $query .= " AND (o.modelo = 'UNKNOWN HHP_HHP' OR o.modelo LIKE 'GT-%' OR o.modelo LIKE 'SGH-%' OR o.modelo LIKE 'SM-%')";
    }
    if (!empty($_POST['departamento']) ) {
        if (!isset($_POST['nombre']) ) {
            $query .= " COLLATE utf8_bin";
        }
    }
    $query .= " ORDER BY o.fechatransaccion desc";
    // echo $query;
    $result = mysqli_query($link, $query);
    if( $_POST['linea'] == 'II' || $_POST['linea'] == 'IH' || $_POST['linea'] == 'HHP' ) {
        echo "<thead>
                <tr>  
                    <th>Fecha</th> 
                    <th>Hora</th> 
                    <th>ASC</th> 
                    <th>Tipo</th> 
                    <th>Orden</th> 
                    <th>Modelo</th>  
                    <th>Tipo de producto</th>  
                    <th>Tipología 1</th>  
                    <th>Tipología 2</th>  
                    <th>Tipología 3</th>  
                    <th>Resolución</th>  
                    <th>Estado</th>  
                    <th>Razón</th>  
                    <th>Almacén</th>  
                    <th>Agente</th>  
                    <th>Cliente</th>  
                    <th>Cédula</th>  
                    <th>Teléfono</th>  
                    <th>Ciudad</th>  
                    <th>Departamento</th>  
                </tr>  
            </thead>
            <tbody>";
            
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
        echo "</tbody>";
    } 
    elseif ( $_POST['linea'] == 'DTV' ) {
        echo "<thead>
            <tr>  
                <th>Fecha</th> 
                <th>Hora</th> 
                <th>ASC</th> 
                <th>Tipo</th> 
                <th>Orden</th> 
                <th>Modelo</th>
                <th>Versión</th>  
                <th>Tipo de producto</th>  
                <th>Tipología 1</th>  
                <th>Tipología 2</th>  
                <th>Tipología 3</th>  
                <th>Resolución</th>  
                <th>Estado</th>  
                <th>Razón</th>  
                <th>Almacén</th>  
                <th>Agente</th>  
                <th>Cliente</th>  
                <th>Cédula</th>  
                <th>Teléfono</th>  
                <th>Ciudad</th>  
                <th>Departamento</th>  
            </tr>  
        </thead>
        <tbody>";
            
        while ($row = mysqli_fetch_row($result)){   
            echo "<tr>";  
            vacio( substr($row[0], 0, 10) );  
            vacio( substr($row[0], -8) );  
            vacio( $row[17] );  
            vacio( $row[16] );  
            vacio( $row[15] );  
            vacio( $row[3] );  
            vacio( $row[18] );  
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
        echo "</tbody>";
    }
?>