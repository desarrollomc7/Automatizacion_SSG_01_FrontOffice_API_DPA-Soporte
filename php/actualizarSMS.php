<?php
    include ("Lista.php");
    include ("conexionSQL.php");
    $conn=sqlsrv_connect($server,$connectionInfo);
    if( $conn === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $sql = "select TOP 1000  Fecha, Login, Numero, Mensaje, Landing, CampanaID FROM [dbo].[sms_Samsung]";
 
   
    if (isset($_POST['agente']) ) {
        $sql .=  "WHERE Login LIKE '%".$_POST['agente']."%'";
    }  

    if (isset($_POST['fecha1']) and $_POST['fecha1'] != '' ) {
        $fecha1 = $_POST['fecha1'];
        $sql  .= " and Fecha >= '".$fecha1."'";
    }
    if (isset($_POST['fecha2']) and $_POST['fecha2'] != '' ) {
        $fecha2 = $_POST['fecha2'];
        $sql .= " and Fecha <= '".$fecha2."'";
    }
    $sql  .= " order by Fecha desc";
    // echo $query;

    
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
                <th>Fecha</th>
                <th>Hora</th>
                <th>Login</th>
                <th>Numero</th>
                <th>Landing</th>
                <th>CampanaID</th>
                <th>Mensaje</th>
            </tr>";
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
     
                echo "<th>".$row['Fecha']->format('Y-m-d')."</th> ";
                echo "<th>".$row['Fecha']->format('H:i:s')."</th> ";
                echo "<th>".$row['Login']."</th>";
                echo "<th>".$row['Numero']."</th>";
                echo "<th>".$row['Landing']."</th>";
                echo "<th>".$row['CampanaID']."</th>";
                echo "<th>".$row['Mensaje']."</th> </tr>";
                
            } 
            sqlsrv_free_stmt( $stmt);
            echo " </table>"; 
            echo "</tbody>";

?>