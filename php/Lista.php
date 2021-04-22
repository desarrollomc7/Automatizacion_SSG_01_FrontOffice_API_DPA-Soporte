<?php
function lista($completo){
    if( strlen($completo) > 2 ) {
        if ( strncmp($completo, "WA", 2) == 0 ) {
            echo "<td>Lavadora</td>";  
        } 
        else if ( strncmp($completo, "RT", 2) == 0 ) {
            echo "<td>Nevera</td>";  
        } 
        else if ( strncmp($completo, "RN", 2) == 0 ) {
            echo "<td>Nevera</td>";  
        } 
        else if ( strncmp($completo, "SC", 2) == 0 ) {
            echo "<td>Impresora</td>";  
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
        else if ( strncmp($completo, "WB", 2) == 0 ) {
            echo "<td>Lavadora</td>";  
        } 
        else if ( strncmp($completo, "WV", 2) == 0 ) {
            echo "<td>Lavadora</td>";  
        } 
        else if ( strncmp($completo, "UD", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "T2", 2) == 0 ) {
            echo "<td>Monitor</td>";  
        } 
        else if ( strncmp($completo, "ED", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "PC", 2) == 0 ) {
            echo "<td>Aire acondicionado</td>";  
        } 
        else if ( strncmp($completo, "QN", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "LT", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "LN", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "CL", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "HW", 2) == 0 ) {
            echo "<td>Sistema de sonido</td>";  
        } 
        else if ( strncmp($completo, "PL", 2) == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strncmp($completo, "LS", 2) == 0 ) {
            echo "<td>Monitor</td>";  
        } 
        else if ( strncmp($completo, "LC", 2) == 0 ) {
            echo "<td>Monitor</td>";  
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
        else if ( strncmp($completo, "MG", 2) == 0 ) {
            echo "<td>Microondas</td>";  
        }
        else if ( strncmp($completo, "AG", 2) == 0 ) {
            echo "<td>Microondas</td>";  
        }
        else if ( strncmp($completo, "MX", 2) == 0 ) {
            echo "<td>Minicomponente</td>";  
        }
        else if ( strncmp($completo, "BD", 2) == 0 ) {
            echo "<td>Blu-Ray</td>";  
        }
        else if ( strncmp($completo, "HT", 2) == 0 ) {
            echo "<td>Teatro en casa</td>";  
        }
        else if ( strncmp($completo, "EO-", 3) == 0 ) {
            echo "<td>Audífonos</td>";  
        }
        else if ( strncmp($completo, "GT-", 3) == 0 ) {
            echo "<td>Celular</td>";  
        }
        else if ( strncmp($completo, "SGH-", 4) == 0 ) {
            echo "<td>Celular</td>";  
        }
        else if ( strncmp($completo, "SM-", 3) == 0 ) {
            echo "<td>Celular</td>";  
        }
        else if ( strncmp($completo, "UN", 2) == 0 and is_numeric($completo[2]) ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN ACN_SPL") == 0 ) {
            echo "<td>Aire acondicionado</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN ACN_OTH") == 0 ) {
            echo "<td>Aire acondicionado</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN HHP_HHP") == 0 ) {
            echo "<td>Celular</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN AUD_OTH") == 0 ) {
            echo "<td>Sistema de sonido</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN CAM_DSC") == 0 ) {
            echo "<td>Cámara fotográfica</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN COM_NPC") == 0 ) {
            echo "<td>Portátil</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN REF_REF") == 0 ) {
            echo "<td>Refrigerador</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN VDE_LCD") == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN VDE_LED") == 0 ) {
            echo "<td>Televisión</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN WSM_DRY") == 0 ) {
            echo "<td>Secadora</td>";  
        } 
        else if ( strcmp($completo, "UNKNOWN WSM_WSM") == 0 ) {
            echo "<td>Lavadora</td>";  
        } 
        else {
            echo "<td>".$completo."</td>";
        }
    } else {
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

function techsee($dato){
    if( $dato == "NO" ){
        return "";
    } else {
        return $dato;
    }
}

function AdjuntosVacios($dato){
    if( $dato == "" ){
        return "0";
    } else {
        return $dato;
    }
}

function linea( $modelo, $sintoma ){
    if( strcmp( $sintoma, "Instalación" ) == 0 ) {
        echo "<td>II</td>";
    } 
    else if( strlen($modelo) <= 2 ) {
        echo "<td>HA</td>";
    }
    else if( ( strncmp($modelo, "UN", 2) == 0 and is_numeric($modelo[2]) ) or strncmp($modelo, "QN", 2) == 0 or strncmp($modelo, "UD", 2) == 0 or strncmp($modelo, "ED", 2) == 0 or strcmp($modelo, "UNKNOWN VDE_LCD") == 0 or strcmp($modelo, "UNKNOWN VDE_LED") == 0) {
        echo "<td>DTV</td>";
    } else if( strcmp($modelo, "UNKNOWN HHP_HHP") == 0 or strncmp($modelo, "GT-", 3) == 0 or strncmp($modelo, "SGH-", 4) == 0 or strncmp($modelo, "SM-", 3) == 0 ) {
        echo "<td>HHP</td>";
    } else {
        echo "<td>HA</td>";
    }
}
?>