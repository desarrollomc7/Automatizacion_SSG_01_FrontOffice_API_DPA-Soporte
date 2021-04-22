<?php
    include ("ListaExport.php");
    include ("conexion.php");   
    if (!($link=mysqli_connect($server,$user,$pass,$db)))  
    {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");
    $query = "select ip, login, versionDPA, ultimaActualizacion from agentesActivos ";
    
    if (isset($_POST['agente']) && $_POST['agente'] != '' ) {
        $query .= " WHERE login = ".$_POST['agente'];
    }
    $query .= " order by login asc";
    // echo $query;
    $result = mysqli_query($link, $query);

    $mensaje = "\xEF\xBB\xBFIP;Login;Version DPA;Última Actualización\n";
        
    while ($row = mysqli_fetch_row($result)){     
        $mensaje .= vacio( $row[0] ).";";  
        $mensaje .= vacio( $row[1] ).";";  
        $mensaje .= vacio( $row[2] ).";";
        $mensaje .= vacio( $row[3] )."\n";  
    }     
    file_put_contents("temp.csv", $mensaje);
?>