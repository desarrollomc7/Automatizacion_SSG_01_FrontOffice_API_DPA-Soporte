<?php
    include ("Lista.php");
    include ("conexionSQL.php");   
    $conn=sqlsrv_connect($server,$connectionInfo);
    if( $conn === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $sql = "select ip, login, versionDPA, ultimaActualizacion from agentesActivos ";
   

    if (isset($_POST['agente']) && $_POST['agente'] != '' ) {
        $sql .= " WHERE login = ".$_POST['agente'];
    }
    $sql .= " order by login asc";
   
    $stmt = sqlsrv_query( $conn, $sql);
    if( !$stmt ) {
        die( print_r( sqlsrv_errors(), true));
    }
   
   
    echo " <style>
    table, th, td {
      border: 1px solid black;
    }
    </style>
            <table class='center'>
            <tr>
                <th>IP</th>
                <th>Login</th>
                <th>Version DPA</th>
                <th>Última Actualización</th>
            </tr>";
     while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
     
        echo "<th>".$row['ip']."</th>";
        echo "<th>".$row['login']."</th>";
        echo "<th>".$row['versionDPA']."</th>";
        echo "<th>".$row['ultimaActualizacion']->format('Y-m-d H:i:s')."</th> </tr>";
        
    }     
    
    sqlsrv_free_stmt( $stmt);
    echo " </table>"; 
    
?>