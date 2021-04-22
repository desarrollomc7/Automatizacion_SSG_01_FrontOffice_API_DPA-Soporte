<?php
    include ("ListaExport.php");
    include ("conexion.php");   
    if (!($link=mysqli_connect($server,$user,$pass,$db)))  
    {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");

    $vars = array(
        '{$fechaTransaccionInicio}'               => '2018-07-01',
        '{$fechaTransaccionFinal}'          => ' ',
        );
        
    $query = 'select * from 
    (select t.fechatransaccion, c.estado as departamento, c.distrito2 as ciudad, t.modelo, t.sintoma_cat1, t.sintoma_cat2, t.sintoma_cat3, t.resolucion, t.estado, t.estado_razon, t.almacen, CONCAT(c.nombre, \' \', c.apellido) AS usuario, t.usuariowindows, c.telefonocelular, t.numeroidentificacion_cliente, s.idpedido, t.prototipo, s.serviciotecnicoautorizado_id, s.version, t.remoto, t.techsee, t.solTechsee, t.versionDPA, c.direccion1, c.id, s.tipo_servicio, t.telefonoTech, s.falla_detallada, s.parte_solicitar, s.software, t.adjuntos, s.adjuntos as adjuntosService, t.habeasData, t.ip  
    from transaccion t LEFT JOIN servicerequest s ON t.idtransaccion = s.numerotransaccion_transaccion
                        LEFT JOIN cliente c ON t.numeroidentificacion_cliente = c.numeroidentificacion
    where t.fechatransaccion >= \'{$fechaTransaccionInicio}\' {$fechaTransaccionFinal} and t.numeroidentificacion_cliente NOT LIKE \'63________\'
    
    UNION ALL
    
    select t.fechatransaccion, c.estado as departamento, c.distrito2 as ciudad, t.modelo, t.sintoma_cat1, t.sintoma_cat2, t.sintoma_cat3, t.resolucion, t.estado, t.estado_razon, t.almacen, CONCAT(c.nombre, \' \', c.apellido) AS usuario, t.usuariowindows, c.telefonocelular, c.numeroidentificacion, s.idpedido, t.prototipo, s.serviciotecnicoautorizado_id, s.version, t.remoto, t.techsee, t.solTechsee, t.versionDPA, c.direccion1, t.numeroidentificacion_cliente, s.tipo_servicio, t.telefonoTech, s.falla_detallada, s.parte_solicitar, s.software, t.adjuntos, s.adjuntos as adjuntosService, t.habeasData, t.ip
    from transaccion t LEFT JOIN servicerequest s ON t.idtransaccion = s.numerotransaccion_transaccion
                        LEFT JOIN cliente c ON t.numeroidentificacion_cliente = c.id 
    
    where t.fechatransaccion >= \'{$fechaTransaccionInicio}\' {$fechaTransaccionFinal} and t.numeroidentificacion_cliente LIKE \'63________\') as consulta where \'casa\' = \'casa\' ';

    if (isset($_POST['departamento']) and $_POST['departamento'] != '' ) {
        $departamentos = $_POST['departamento'];
        $query .= " AND (";
        foreach ( $departamentos as $valor ){
            $query .= " consulta.departamento = '".$valor."' OR";
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    if (isset($_POST['ciudad']) and $_POST['ciudad'] != '' ) {
        $ciudades = $_POST['ciudad'];
        $query .= " AND (";
        foreach ( $ciudades as $valor ){
            $query .= " consulta.ciudad = '".$valor."' OR";
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }
    if (isset($_POST['tipo1']) and $_POST['tipo1'] != '' ) {
        $tipos = $_POST['tipo1'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            if( $valor == "*Sin datos"){
                $query .= " consulta.sintoma_cat1 = '' OR";
            } else {
                $query .= " consulta.sintoma_cat1 = '".$valor."' OR";
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
                $query .= " consulta.sintoma_cat3 = '' OR";
            } else {
                $query .= " consulta.sintoma_cat3 = '".$valor."' OR";
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
                $query .= " consulta.almacen = '' OR";
            } else {
                $query .= " consulta.almacen = '".$valor."' OR";
            }
        }
        $query = substr($query,0,-2);
        $query .= " )";
    }

    if (isset($_POST['agente']) ) {
        $query .= " AND consulta.usuariowindows LIKE '%".$_POST['agente']."%'";
    }

    if (isset($_POST['cedula']) and $_POST['cedula'] != '' ) {
        $query .= " AND consulta.numeroidentificacion_cliente LIKE '%".$_POST['cedula']."%'";
    }

    if (isset($_POST['estado']) and $_POST['estado'] != '' ) {
        $tipos = $_POST['estado'];
        $query .= " AND (";
        foreach ( $tipos as $valor ){
            if( $valor == "*Sin datos"){
                $query .= " consulta.estado = '' OR";
            } else {
                $query .= " consulta.estado = '".$valor."' OR";
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
        $vars['{$fechaTransaccionInicio}'] = $fecha1;
        // $query .= " AND consulta.fechatransaccion >= '".$fecha1."'";
    }
    if (isset($_POST['fecha2']) and $_POST['fecha2'] != '' ) {
        $fecha2 = $_POST['fecha2'];
        $vars['{$fechaTransaccionFinal}'] = ' AND t.fechatransaccion < \''.$fecha2.'\'';
        // $query .= " AND consulta.fechatransaccion <= '".$fecha2."'";
    }
    if ( isset($_POST['linea']) ) {
        $linea = $_POST['linea'];
        if( $linea == 'DTV' )
            $query .= " AND (consulta.modelo LIKE 'UN%' OR consulta.modelo LIKE 'QN%') AND (consulta.modelo NOT LIKE 'UNK%' OR consulta.modelo = 'UNKNOWN VDE_LED' OR consulta.modelo = 'UNKNOWN VDE_LCD')";
        else if( $linea == 'II' )
            $query .= " AND consulta.sintoma_cat1 = 'Instalación'";
        else if( $linea == 'IH' )
            $query .= " AND (consulta.sintoma_cat1 != 'Instalación' AND consulta.modelo != 'UNKNOWN VDE_LED' AND consulta.modelo != 'UNKNOWN VDE_LCD' AND consulta.modelo != 'UNKNOWN HHP_HHP' AND consulta.modelo NOT LIKE 'GT-%' AND consulta.modelo NOT LIKE 'SGH-%' AND consulta.modelo NOT LIKE 'SM-%' AND consulta.modelo NOT LIKE 'QN%') AND consulta.modelo NOT REGEXP 'UN[0-9]'";
        else if( $linea == 'HHP' )
            $query .= " AND (consulta.modelo = 'UNKNOWN HHP_HHP' OR consulta.modelo LIKE 'GT-%' OR consulta.modelo LIKE 'SGH-%' OR consulta.modelo LIKE 'SM-%')";
    }
    // if (!empty($_POST['departamento']) ) {
    //     if (!isset($_POST['nombre']) ) {
    //         $query .= " COLLATE utf8_bin";
    //     }
    // }
    $query .= " ORDER BY consulta.fechatransaccion desc;";
    $query = strtr($query, $vars);
    // echo $query;
    $result = mysqli_query($link, $query);
    if( $_POST['linea'] == 'II' ) {
        $mensaje = "\xEF\xBB\xBFFecha;Hora;ASC;Tipo;Orden;Modelo;Tipo de producto;Tipología 1;Tipología 2;Tipología 3;Resolución;Estado;Razón;Almacén;Agente;Cliente;Cédula;ID;Dirección;Teléfono;Ciudad;Departamento;Techsee;Soluciono Techsee;Telefono Techsee;Tipo Servicio;Habeas Data;Version DPA;IP\n";

        while ($row = mysqli_fetch_row($result)){   
            $mensaje .= vacio( substr($row[0], 0, 10) ).";";
            $mensaje .= vacio( substr($row[0], -8) ).";";
            $mensaje .= vacio( $row[17] ).";";
            $mensaje .= vacio( $row[16] ).";";
            $mensaje .= vacio( $row[15] ).";";
            $mensaje .= vacio( $row[3] ).";";
            $mensaje .= lista( $row[3] ).";";
            $mensaje .= vacio( $row[4] ).";";
            $mensaje .= vacio( $row[5] ).";";
            $mensaje .= vacio( $row[6] ).";";
            $mensaje .= vacio( $row[7] ).";";
            $mensaje .= vacio( $row[8] ).";";
            $mensaje .= vacio( $row[9] ).";";
            $mensaje .= vacio( $row[10] ).";";
            $mensaje .= vacio( $row[12] ).";";
            $mensaje .= vacio( $row[11] ).";";
            $mensaje .= vacio( $row[14] ).";";
            $mensaje .= vacio( $row[24] ).";";
            $mensaje .= vacio( $row[23] ).";";
            $mensaje .= vacio( $row[13] ).";";
            $mensaje .= vacio( $row[2] ).";";
            $mensaje .= vacio( $row[1] ).";";
            $mensaje .= vacio( $row[20] ).";";
            $mensaje .= vacio( $row[21] ).";";
            $mensaje .= vacio( $row[26] ).";";
            $mensaje .= vacio( $row[25] ).";";
            $mensaje .= vacio( $row[32] ).";";
            $mensaje .= vacio( $row[22] ).";";
            $mensaje .= vacio( $row[33] )."\n";
        }  
        file_put_contents("temp.csv", $mensaje);
    } 
    if( $_POST['linea'] == 'IH' ) {
        $mensaje = "\xEF\xBB\xBFFecha;Hora;ASC;Tipo;Orden;Modelo;Tipo de producto;Tipología 1;Tipología 2;Tipología 3;Resolución;Estado;Razón;Almacén;Agente;Cliente;Cédula;ID;Dirección;Teléfono;Ciudad;Departamento;Techsee;Soluciono Techsee;Telefono Techsee;Tipo Servicio;Falla detallada;Habeas Data;Version DPA;IP\n";

        while ($row = mysqli_fetch_row($result)){   
            $mensaje .= vacio( substr($row[0], 0, 10) ).";";
            $mensaje .= vacio( substr($row[0], -8) ).";";
            $mensaje .= vacio( $row[17] ).";";
            $mensaje .= vacio( $row[16] ).";";
            $mensaje .= vacio( $row[15] ).";";
            $mensaje .= vacio( $row[3] ).";";
            $mensaje .= lista( $row[3] ).";";
            $mensaje .= vacio( $row[4] ).";";
            $mensaje .= vacio( $row[5] ).";";
            $mensaje .= vacio( $row[6] ).";";
            $mensaje .= vacio( $row[7] ).";";
            $mensaje .= vacio( $row[8] ).";";
            $mensaje .= vacio( $row[9] ).";";
            $mensaje .= vacio( $row[10] ).";";
            $mensaje .= vacio( $row[12] ).";";
            $mensaje .= vacio( $row[11] ).";";
            $mensaje .= vacio( $row[14] ).";";
            $mensaje .= vacio( $row[24] ).";";
            $mensaje .= vacio( $row[23] ).";";
            $mensaje .= vacio( $row[13] ).";";
            $mensaje .= vacio( $row[2] ).";";
            $mensaje .= vacio( $row[1] ).";";
            $mensaje .= vacio( $row[20] ).";";
            $mensaje .= vacio( $row[21] ).";";
            $mensaje .= vacio( $row[26] ).";";
            $mensaje .= vacio( $row[25] ).";";
            $mensaje .= vacio( $row[27] ).";";
            $mensaje .= vacio( $row[32] ).";";
            $mensaje .= vacio( $row[22] ).";";
            $mensaje .= vacio( $row[33] )."\n";
        }  
        file_put_contents("temp.csv", $mensaje);
    } 
    if( $_POST['linea'] == 'HHP' ) {
        $mensaje = "\xEF\xBB\xBFFecha;Hora;ASC;Tipo;Orden;Modelo;Tipo de producto;Tipología 1;Tipología 2;Tipología 3;Resolución;Estado;Razón;Almacén;Agente;Cliente;Cédula;ID;Dirección;Teléfono;Ciudad;Departamento;Tipo Servicio;Habeas Data;Version DPA;IP\n";

        while ($row = mysqli_fetch_row($result)){   
            $mensaje .= vacio( substr($row[0], 0, 10) ).";";
            $mensaje .= vacio( substr($row[0], -8) ).";";
            $mensaje .= vacio( $row[17] ).";";
            $mensaje .= vacio( $row[16] ).";";
            $mensaje .= vacio( $row[15] ).";";
            $mensaje .= vacio( $row[3] ).";";
            $mensaje .= lista( $row[3] ).";";
            $mensaje .= vacio( $row[4] ).";";
            $mensaje .= vacio( $row[5] ).";";
            $mensaje .= vacio( $row[6] ).";";
            $mensaje .= vacio( $row[7] ).";";
            $mensaje .= vacio( $row[8] ).";";
            $mensaje .= vacio( $row[9] ).";";
            $mensaje .= vacio( $row[10] ).";";
            $mensaje .= vacio( $row[12] ).";";
            $mensaje .= vacio( $row[11] ).";";
            $mensaje .= vacio( $row[14] ).";";
            $mensaje .= vacio( $row[24] ).";";
            $mensaje .= vacio( $row[23] ).";";
            $mensaje .= vacio( $row[13] ).";";
            $mensaje .= vacio( $row[2] ).";";
            $mensaje .= vacio( $row[1] ).";";
            $mensaje .= vacio( $row[25] ).";";
            $mensaje .= vacio( $row[32] ).";";
            $mensaje .= vacio( $row[22] ).";";
            $mensaje .= vacio( $row[33] )."\n";
        }  
        file_put_contents("temp.csv", $mensaje);
    } 
    elseif ( $_POST['linea'] == 'DTV' ) {
        $mensaje = "\xEF\xBB\xBFFecha;Hora;ASC;Tipo;Orden;Modelo;Versión;Tipo de producto;Tipología 1;Tipología 2;Tipología 3;Resolución;Estado;Razón;Almacén;Agente;Cliente;Cédula;ID;Dirección;Teléfono;Ciudad;Departamento;Remoto;Techsee;Soluciono Techsee;Telefono Techsee;Tipo Servicio;Falla detallada;Parte a solicitar;Software;Habeas Data;Version DPA;IP\n";
            
        while ($row = mysqli_fetch_row($result)){   
            $mensaje .= vacio( substr($row[0], 0, 10) ).";";
            $mensaje .= vacio( substr($row[0], -8) ).";";
            $mensaje .= vacio( $row[17] ).";";
            $mensaje .= vacio( $row[16] ).";";
            $mensaje .= vacio( $row[15] ).";";
            $mensaje .= vacio( $row[3] ).";";
            $mensaje .= vacio( $row[18] ).";";
            $mensaje .= lista( $row[3] ).";";
            $mensaje .= vacio( $row[4] ).";";
            $mensaje .= vacio( $row[5] ).";";
            $mensaje .= vacio( $row[6] ).";";
            $mensaje .= vacio( $row[7] ).";";
            $mensaje .= vacio( $row[8] ).";";
            $mensaje .= vacio( $row[9] ).";";
            $mensaje .= vacio( $row[10] ).";";
            $mensaje .= vacio( $row[12] ).";";
            $mensaje .= vacio( $row[11] ).";";
            $mensaje .= vacio( $row[14] ).";";
            $mensaje .= vacio( $row[24] ).";";
            $mensaje .= vacio( $row[23] ).";";
            $mensaje .= vacio( $row[13] ).";";
            $mensaje .= vacio( $row[2] ).";";
            $mensaje .= vacio( $row[1] ).";";
            $mensaje .= vacio( $row[19] ).";";
            $mensaje .= vacio( $row[20] ).";";
            $mensaje .= vacio( $row[21] ).";";
            $mensaje .= vacio( $row[26] ).";";
            $mensaje .= vacio( $row[25] ).";";
            $mensaje .= vacio( $row[27] ).";";
            $mensaje .= vacio( $row[28] ).";";
            $mensaje .= vacio( $row[29] ).";";
            $mensaje .= vacio( $row[32] ).";";
            $mensaje .= vacio( $row[22] ).";";
            $mensaje .= vacio( $row[33] )."\n";
        }     
        file_put_contents("temp.csv", $mensaje);
    }
    elseif ( $_POST['linea'] == 'ALL' ) {
        $mensaje = "\xEF\xBB\xBFFecha;Hora;ASC;Tipo;Orden;Modelo;Tipo de producto;Tipología 1;Tipología 2;Tipología 3;Resolución;Estado;Razón;Almacén;Agente;Cliente;Cédula;ID;Dirección;Teléfono;Ciudad;Departamento;Linea;Techsee;Soluciono Techsee;Telefono Techsee;Tipo Servicio;Falla detallada;Parte a solicitar;Software;Versión;Adj. Transaccion;Adj. Service;Habeas Data;Version DPA;IP\n";
            
        while ($row = mysqli_fetch_row($result)){   
            $mensaje .= vacio( substr($row[0], 0, 10) ).";";  
            $mensaje .= vacio( substr($row[0], -8) ).";";  
            $mensaje .= vacio( $row[17] ).";";  
            $mensaje .= vacio( $row[16] ).";";  
            $mensaje .= vacio( $row[15] ).";";  
            $mensaje .= vacio( $row[3] ).";";   
            $mensaje .= lista( $row[3] ).";";
            $mensaje .= vacio( $row[4] ).";";  
            $mensaje .= vacio( $row[5] ).";";  
            $mensaje .= vacio( $row[6] ).";";  
            $mensaje .= vacio( $row[7] ).";";  
            $mensaje .= vacio( $row[8] ).";";  
            $mensaje .= vacio( $row[9] ).";";  
            $mensaje .= vacio( $row[10] ).";";  
            $mensaje .= vacio( $row[12] ).";";  
            $mensaje .= vacio( $row[11] ).";";  
            $mensaje .= vacio( $row[14] ).";";  
            $mensaje .= vacio( $row[24] ).";";  
            $mensaje .= vacio( $row[23] ).";";  
            $mensaje .= vacio( $row[13] ).";";  
            $mensaje .= vacio( $row[2] ).";";
            $mensaje .= vacio( $row[1] ).";";  
            $mensaje .= linea( $row[3],$row[4] ).";";
            $mensaje .= vacio( techsee($row[20]) ).";";
            $mensaje .= vacio( $row[21] ).";";
            $mensaje .= vacio( $row[26] ).";";
            $mensaje .= vacio( $row[25] ).";";
            $mensaje .= vacio( $row[27] ).";";
            $mensaje .= vacio( $row[28] ).";";
            $mensaje .= vacio( $row[29] ).";";
            $mensaje .= vacio( $row[18] ).";";
            $mensaje .= vacio( AdjuntosVacios($row[30]) ).";";
            $mensaje .= vacio( AdjuntosVacios($row[31]) ).";";
            $mensaje .= vacio( $row[32] ).";";
            $mensaje .= vacio( $row[22] ).";";
            $mensaje .= vacio( $row[33] )."\n";
        }     
        file_put_contents("temp.csv", $mensaje);
    }
?>