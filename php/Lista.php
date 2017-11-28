<?php
function lista($completo){
    if ( strncmp($completo, "WA", 2) == 0 ) {
        echo "<td>Lavadora</td>";  
    } 
    else if ( strncmp($completo, "RT", 2) == 0 ) {
        echo "<td>Nevera</td>";  
    } 
    else if ( strncmp($completo, "WF", 2) == 0 ) {
        echo "<td>Lavadora</td>";  
    } 
    else if ( strncmp($completo, "DV", 2) == 0 ) {
        echo "<td>Secadora</td>";  
    } 
    else if ( strncmp($completo, "WD", 2) == 0 ) {
        echo "<td>Lavadora</td>";  
    } 
    else if ( strncmp($completo, "RS", 2) == 0 ) {
        echo "<td>Nevecom</td>";  
    } 
    else if ( strncmp($completo, "RF", 2) == 0 ) {
        echo "<td>Nevecom</td>";  
    } 
    else if ( strncmp($completo, "RH", 2) == 0 ) {
        echo "<td>Nevecom</td>";  
    } 
    else if ( strncmp($completo, "AR", 2) == 0 ) {
        echo "<td>Aire acondicionado</td>";  
    } 
    else if ( strncmp($completo, "AS", 2) == 0 ) {
        echo "<td>Aire acondicionado</td>";  
    } 
    else if ( strncmp($completo, "AM", 2) == 0 ) {
        echo "<td>Aire acondicionado</td>";  
    } 
    else if ( strncmp($completo, "RL", 2) == 0 ) {
        echo "<td>Nevera</td>";  
    } 
    else if ( strncmp($completo, "AC", 2) == 0 ) {
        echo "<td>Aire acondicionado</td>";  
    } 
    else if ( strncmp($completo, "UH", 2) == 0 ) {
        echo "<td>Aire acondicionado</td>";  
    } 
    else if ( strncmp($completo, "WO", 2) == 0 ) {
        echo "<td>Lavadora</td>";  
    } 
    else if ( strncmp($completo, "UD", 2) == 0 ) {
        echo "<td>Televisor</td>";  
    } 
    else if ( strncmp($completo, "T2", 2) == 0 ) {
        echo "<td>Monitor</td>";  
    } 
    else if ( strncmp($completo, "ED", 2) == 0 ) {
        echo "<td>Televisor</td>";  
    } 
    else if ( strncmp($completo, "PC", 2) == 0 ) {
        echo "<td>Aire acondicionado</td>";  
    } 
    else if ( strncmp($completo, "QN", 2) == 0 ) {
        echo "<td>Televisor</td>";  
    } 
    else if ( strncmp($completo, "PN", 2) == 0 ) {
        echo "<td>Monitor</td>";  
    } 
    else if ( strncmp($completo, "DP", 2) == 0 ) {
        echo "<td>Monitor</td>";  
    } 
    else if ( strncmp($completo, "DB", 2) == 0 ) {
        echo "<td>Monitor</td>";  
    }
    else if ( strncmp($completo, "UN", 2) == 0 and is_numeric($completo[2]) ) {
        echo "<td>Televisor</td>";  
    } 
    else if ( strncmp($completo, "UN", 2) == 0 and !is_numeric($completo[2]) ) {
        echo "<td>Desconocido</td>";  
    } 
    else {
        echo "<td>".$completo."</td>";
    }
}

function vacio($dato){
    if( $dato == "" ) {
        // echo "<td>--Sin datos--</td>";
        echo "<td><i>*Sin datos</i></td>";
        // echo "<td>----</td>";
    } else {
        echo "<td>".$dato."</td>";
    }
}
?>