<?php
    include("conexion.php");
    // $server = "10.164.62.124";
    // $user = "root";
    // $pass = "qwerty";
    // $db = "samsung";
    // // $server = "localhost";
    // // $user = "root";
    // // $pass = "";
    // // $db = "samsung";
    
    if (!($link=mysqli_connect($server,$user,$pass,$db)))  
    {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");
    
    $departamentos = $_POST['departamento'];
    // $departamento = $_POST['departamento'];
 
    $query = "SELECT c.distrito2 FROM cliente c, transaccion t WHERE ";

    $query .= " (";
    foreach ( $departamentos as $valor ){
        $query .= " c.estado = '".$valor."' OR";
    }
    $query = substr($query,0,-2);
    $query .= " )";

    $query .= " AND c.numeroidentificacion = t.numeroidentificacion_cliente;";


    echo $query;

    $result = mysqli_query($link, $query);
    $lista = array();
    while($row = mysqli_fetch_row($result))
    {
        $lista[] = $row[0];
    }
    $lista = array_unique( $lista );
    sort( $lista );
    array_unshift( $lista, "" );
    foreach( $lista as $valor ) {
        echo '<option value = "'.$valor.'">'.$valor.'</option>';
    }
?>