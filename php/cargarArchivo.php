<?php
    include("conexion.php");
    header('Content-Type: text/html; charset=UTF-8'); 
    
    if (!($link=mysqli_connect($server,$user,$pass,$db)) ) {  
        echo "Error conectando a la base de datos.";  
        exit();  
    }  
    mysqli_set_charset($link, "utf8");  

    if( isset($_FILES['file']['name']) && $_FILES['file']['name'] != "" ) {
        $dir_subida = '../data/'.$_POST['tipo'].'/';
        
        if( $_POST['form'] == "si" ) {
            if( $_POST['tipo'] == "ASC" ) {
                $nombre = "ASC_".$_POST['fecha']."_".$_POST['hora'].".csv";
                $nombre = str_replace(":","-",$nombre);
            } else {
                $nombre = $_POST['tipo'].".csv";
            }
        } else {
            $nombre = $_POST['nombre'];
        }           
        
        $fichero_subido = $dir_subida.basename($nombre);

        echo '<div id="respuesta" style="display: block" >';
        if (copy($_FILES['file']['tmp_name'], "../data/temp.csv")) {
            $result = exec("..\Conversor.exe ../data/temp.csv $fichero_subido ".$_POST['tipo']);
            if( $result != "Completado..." ) {
                echo "<h2>Error en Archivo</h2>";
                echo "<p>".$result."</p>";
            } else {
                $tipo = $_POST['tipo'];
                if( $tipo == "ASC" ) {
                    asc();
                } else
                if( $tipo == "TIPIFICACION" ) {
                    tipificacion();
                } else
                if( $tipo == "PRODUCTOS" ) {
                    productos();
                }						
            }                    
        } else {
            echo "<p>No se pudo subir el archivo</p>";
        }
    }
    
    function asc(){
        global $fichero_subido;
        global $link;
        $query = "truncate samsung.asc2";
        $result = mysqli_query($link, $query);
        if( $result == 0 ) {
            echo "<p>Error Borrando base anterior ASC. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
        } else {
            $query = "load data local infile '$fichero_subido' into table samsung.asc2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`TIPO DE SERVICIO`,`OG`,`ASC`,`Ciudad`,`Departamento`,`TIPO DE ORDEN`,`RELLAMADO`,`Almacen de compra`,`PRIORIDAD`,`RUTA`,`Observacion`,`Regional`,`LED`,`LCD`,`LFD`,`REF`,`WSM`,`DRY`,`SRA`,`DVM`);";
            $result = mysqli_query($link, $query);
            if( $result == 0 ) {
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "<p>".mysqli_error($link)."</p>";
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@grupodigitex.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

    function tipificacion(){
        global $fichero_subido;
        global $link;
        $query = "truncate samsung.tipificacion2";
        $result = mysqli_query($link, $query);
        if( $result == 0 ) {
            echo "<p>Error Borrando base anterior TIPIFICACION. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
        } else {
            $query = "load data local infile '$fichero_subido' into table samsung.tipificacion CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`producto`,`sintoma 1`,`sintoma 2`,`sintoma 3`,`sintoma 4`,`Procedimiento`);";
            $result = mysqli_query($link, $query);
            if( $result == 0 ) {
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "<p>".mysqli_error($link)."</p>";
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@grupodigitex.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

    function productos(){
        global $fichero_subido;
        global $link;
        $query = "truncate samsung.dpa_productos2";
        $result = mysqli_query($link, $query);
        if( $result == 0 ) {
            echo "<p>Error Borrando base anterior PRODUCTOS. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
        } else {
            $query = "load data local infile '$fichero_subido' into table samsung.dpa_productos CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`PRODUCTOS`,`TIPO`,`PERTENECE`,`BLOQ_SINTOMA`);";
            $result = mysqli_query($link, $query);
            if( $result == 0 ) {
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "<p>".mysqli_error($link)."</p>";
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@grupodigitex.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }
?>
