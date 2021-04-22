<?php
function lista($completo){
    if( strlen($completo) > 2 ) {
        if ( strncmp($completo, "WA", 2) == 0 ) {
            return "Lavadora";  
        } 
        else if ( strncmp($completo, "RT", 2) == 0 ) {
            return "Nevera";  
        } 
        else if ( strncmp($completo, "RN", 2) == 0 ) {
            return "Nevera";  
        } 
        else if ( strncmp($completo, "SC", 2) == 0 ) {
            return "Impresora";  
        } 
        else if ( strncmp($completo, "WF", 2) == 0 ) {
            return "Lavadora";  
        } 
        else if ( strncmp($completo, "DV", 2) == 0 ) {
            return "Secadora";  
        } 
        else if ( strncmp($completo, "WD", 2) == 0 ) {
            return "Lavadora";  
        } 
        else if ( strncmp($completo, "RS", 2) == 0 ) {
            return "Nevecom";  
        } 
        else if ( strncmp($completo, "RF", 2) == 0 ) {
            return "Nevecom";  
        } 
        else if ( strncmp($completo, "RH", 2) == 0 ) {
            return "Nevecom";  
        } 
        else if ( strncmp($completo, "AR", 2) == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strncmp($completo, "AS", 2) == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strncmp($completo, "AM", 2) == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strncmp($completo, "RL", 2) == 0 ) {
            return "Nevera";  
        } 
        else if ( strncmp($completo, "AC", 2) == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strncmp($completo, "UH", 2) == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strncmp($completo, "WO", 2) == 0 ) {
            return "Lavadora";  
        } 
        else if ( strncmp($completo, "WB", 2) == 0 ) {
            return "Lavadora";  
        } 
        else if ( strncmp($completo, "WV", 2) == 0 ) {
            return "Lavadora";  
        } 
        else if ( strncmp($completo, "UD", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "T2", 2) == 0 ) {
            return "Monitor";  
        } 
        else if ( strncmp($completo, "ED", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "PC", 2) == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strncmp($completo, "QN", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "LT", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "LN", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "CL", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "HW", 2) == 0 ) {
            return "Sistema de sonido";  
        } 
        else if ( strncmp($completo, "PL", 2) == 0 ) {
            return "Televisión";  
        } 
        else if ( strncmp($completo, "LS", 2) == 0 ) {
            return "Monitor";  
        } 
        else if ( strncmp($completo, "LC", 2) == 0 ) {
            return "Monitor";  
        } 
        else if ( strncmp($completo, "PN", 2) == 0 ) {
            return "Monitor";  
        } 
        else if ( strncmp($completo, "DP", 2) == 0 ) {
            return "Monitor";  
        } 
        else if ( strncmp($completo, "DB", 2) == 0 ) {
            return "Monitor";  
        }
        else if ( strncmp($completo, "MG", 2) == 0 ) {
            return "Microondas";  
        }
        else if ( strncmp($completo, "AG", 2) == 0 ) {
            return "Microondas";  
        }
        else if ( strncmp($completo, "MX", 2) == 0 ) {
            return "Minicomponente";  
        }
        else if ( strncmp($completo, "BD", 2) == 0 ) {
            return "Blu-Ray";  
        }
        else if ( strncmp($completo, "HT", 2) == 0 ) {
            return "Teatro en casa";  
        }
        else if ( strncmp($completo, "EO-", 3) == 0 ) {
            return "Audífonos";  
        }
        else if ( strncmp($completo, "GT-", 3) == 0 ) {
            return "Celular";  
        }
        else if ( strncmp($completo, "SGH-", 4) == 0 ) {
            return "Celular";  
        }
        else if ( strncmp($completo, "SM-", 3) == 0 ) {
            return "Celular";  
        }
        else if ( strncmp($completo, "UN", 2) == 0 and is_numeric($completo[2]) ) {
            return "Televisión";  
        } 
        else if ( strcmp($completo, "UNKNOWN ACN_SPL") == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strcmp($completo, "UNKNOWN ACN_OTH") == 0 ) {
            return "Aire acondicionado";  
        } 
        else if ( strcmp($completo, "UNKNOWN HHP_HHP") == 0 ) {
            return "Celular";  
        } 
        else if ( strcmp($completo, "UNKNOWN AUD_OTH") == 0 ) {
            return "Sistema de sonido";  
        } 
        else if ( strcmp($completo, "UNKNOWN CAM_DSC") == 0 ) {
            return "Cámara fotográfica";  
        } 
        else if ( strcmp($completo, "UNKNOWN COM_NPC") == 0 ) {
            return "Portátil";  
        } 
        else if ( strcmp($completo, "UNKNOWN REF_REF") == 0 ) {
            return "Refrigerador";  
        } 
        else if ( strcmp($completo, "UNKNOWN VDE_LCD") == 0 ) {
            return "Televisión";  
        } 
        else if ( strcmp($completo, "UNKNOWN VDE_LED") == 0 ) {
            return "Televisión";  
        } 
        else if ( strcmp($completo, "UNKNOWN WSM_DRY") == 0 ) {
            return "Secadora";  
        } 
        else if ( strcmp($completo, "UNKNOWN WSM_WSM") == 0 ) {
            return "Lavadora";  
        } 
        else {
            return "".$completo."";
        }
    } else {
        return "".$completo."";
    }
}

function vacio($dato){
    if( $dato == "" ) {
        // return "--Sin datos--";
        return "*Sin datos";
        // return "----";
    } else {
        $search  = array('&nbsp;', '&amp;','&241','&ntilde;','&209');
        $replace = array(' ','&','ñ','ñ','Ñ');
        return str_replace ( $search , $replace , $dato);
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
        return "II";
    } 
    else if( strlen($modelo) <= 2 ) {
        return "HA";
    }
    else if( ( strncmp($modelo, "UN", 2) == 0 and is_numeric($modelo[2]) ) or strncmp($modelo, "QN", 2) == 0 or strncmp($modelo, "UD", 2) == 0 or strncmp($modelo, "ED", 2) == 0 or strcmp($modelo, "UNKNOWN VDE_LCD") == 0 or strcmp($modelo, "UNKNOWN VDE_LED") == 0) {
        return "DTV";
    } else if( strcmp($modelo, "UNKNOWN HHP_HHP") == 0 or strncmp($modelo, "GT-", 3) == 0 or strncmp($modelo, "SGH-", 4) == 0 or strncmp($modelo, "SM-", 3) == 0 ) {
        return "HHP";
    } else {
        return "HA";
    }
}
?>