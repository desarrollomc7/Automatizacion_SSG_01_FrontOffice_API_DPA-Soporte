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
        $dir_subidaSQL = '//COSVRPRUEBADPA1/data/'.$_POST['tipo'].'/';
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
        $fichero_subidoSQL = $dir_subidaSQL.basename($nombre);

        echo '<div id="respuesta" style="display: block" >';
        if (copy($_FILES['file']['tmp_name'], "../data/temp.csv")) {
            echo "..\\Conversor.exe ..\\data\\temp.csv $fichero_subido ".$_POST['tipo'];
            $result = exec("..\\Conversor.exe ..\\data\\temp.csv $fichero_subido ".$_POST['tipo']);
         
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
                } else						
                if( $tipo == "PARTES" ) {
                    partes();
                } else						
                if( $tipo == "SMS" ) {
                    sms();
                } else						
                if( $tipo == "ZONAROJA" ) {
                    zonaroja();
                } else						
                if( $tipo == "ALERTA" ) {
                    alerta();
                } else						
                if( $tipo == "IILINEA" ) {
                    iilinea();
                }								
            }                    
        } else {
            echo "<p>No se pudo subir el archivo</p>";
        }
    }
    
    function asc(){
        global $fichero_subido;
        global $link;
        $query = "truncate samsung.asc";
        $result = mysqli_query($link, $query);
        if( $result == 0 ) {
            echo "<p>Error Borrando base anterior ASC. Escriba al área de Automatización - Bogotá</p>";
        } else {
            $query = "load data Local infile '$fichero_subido' into table samsung.asc CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`TIPO DE SERVICIO`,`OG`,`ASC`,`Ciudad`,`Departamento`,`TIPO DE ORDEN`,`RELLAMADO`,`Almacen de compra`,`PRIORIDAD`,`RUTA`,`Observacion`,`Regional`,`LED`,`LCD`,`LFD`,`REF`,`WSM`,`DRY`,`SRA`,`DVM`);";
           echo $query;
            $result = mysqli_query($link, $query);
			 echo "<p>".mysqli_error($link)."</p>";
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
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
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
            echo "<p>Error Borrando base anterior TIPIFICACION. Escriba al área de Automatización - Bogotá</p>";
        } else {
            $query = "load data local infile '$fichero_subido' into table samsung.tipificacion2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`linea`,`producto`,`sintoma 1`,`sintoma 2`,`sintoma 3`,`sintoma 4 con`,`sintoma 4 sin`,`Procedimiento`,`parte`);";
            echo $query ;
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
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

    function productos(){
        global $fichero_subido;
        global $link;
        $query = "truncate samsung.dpa_productos";
        $result = mysqli_query($link, $query);
        if( $result == 0 ) {
            echo "<p>Error Borrando base anterior PRODUCTOS. Escriba al área de Automatización - Bogotá</p>";
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
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

    function partes(){
        global $fichero_subido;
        global $link;
        $query = "truncate samsung.partes";
        $result = mysqli_query($link, $query);
        if( $result == 0 ) {
            echo "<p>Error Borrando base anterior PARTES. Escriba al área de Automatización - Bogotá</p>";
        } else {
            $query = "load data local infile '$fichero_subido' into table samsung.partes CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`linea`,`parte`);";
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
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

    function sms(){
        include ("conexionSQL.php");   
        global $fichero_subidoSQL;
        global $link;
        $conn=sqlsrv_connect($server,$connectionInfo);
        if( $conn === false) {
            die( print_r( sqlsrv_errors(), true));
        }
  
        $sql = "truncate table landingPages";
         $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            echo "<p>Error Borrando base anterior landingPages. Escriba al área de Automatización - Bogotá</p>";
            die( print_r( sqlsrv_errors(), true));
        }else{
             
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
           $sql="BULK INSERT landingPagesTemporal FROM '$fichero_subidoSQL' 
            WITH
            (
                FIRSTROW = 2,
                FIELDTERMINATOR = ';',
                ROWTERMINATOR = '\\n',
                CODEPAGE=65001
            
            )";
         
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
                $errors = sqlsrv_errors();
            }
            $sql="insert INTO [dbo].[landingPages] ([Landing] ,[Titulo] ,[Linea] ,[Mensaje] ,[CampanaID])                   
            SELECT [Landing] ,[Titulo],[Linea] ,[Mensaje] ,[CampanaID] FROM [dbo].[landingPagesTemporal]";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
                       
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $sql = "truncate table landingPagesTemporal";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "message: ".$error[ 'message']."<br />";
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

	 function zonaroja(){

        include ("conexionSQL.php");   
        global $fichero_subidoSQL;
        global $link;
        $conn=sqlsrv_connect($server,$connectionInfo);
        if( $conn === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $sql = "truncate table zonaRoja";
        
        $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            echo "<p>Error Borrando base anterior ZonaRoja. Escriba al área de Automatización - Bogotá</p>";
            die( print_r( sqlsrv_errors(), true));
        }else{
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
                $errors = sqlsrv_errors();
            }
            $sql="BULK INSERT [zonaRojaTemporal] FROM '$fichero_subidoSQL' 
            WITH
            (
                FIRSTROW = 2,
                FIELDTERMINATOR = ';',
                ROWTERMINATOR = '\\n',
                CODEPAGE=65001            
            )";   
            echo $sql;
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $sql="insert INTO [dbo].[zonaRoja] ([Tipo] ,[Nombre] ,[Pertenece])                  
            SELECT [Tipo] ,[Nombre] ,[Pertenece]FROM [dbo].[zonaRojaTemporal]";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
                       
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $sql = "truncate table zonaRojaTemporal";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
            
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "message: ".$error[ 'message']."<br />";
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }

    function alerta(){
        include ("conexionSQL.php");   
        global $fichero_subidoSQL;
        global $link;
        $conn=sqlsrv_connect($server,$connectionInfo);
        if( $conn === false) {
            die( print_r( sqlsrv_errors(), true));
        }
  
        $sql = "truncate table alertas";
         $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            echo "<p>Error Borrando base anterior Alertas. Escriba al área de Automatización - Bogotá</p>";
            die( print_r( sqlsrv_errors(), true));
        }else{
             
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $sql="BULK INSERT alertasTemporal FROM '$fichero_subidoSQL' 
            WITH
            (
                FIRSTROW = 2,
                FIELDTERMINATOR = ';',
                ROWTERMINATOR = '\\n',
                CODEPAGE=65001     
                
            )";
            echo  $sql;
                     
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $sql="Insert INTO [dbo].[alertas] ([Valor],[Mensaje])                    
                        SELECT [Valor],[Mensaje]
                        FROM  alertasTemporal";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
                       
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
                $errors = sqlsrv_errors();
            }
            $sql = "truncate table alertasTemporal";
            $stmt = sqlsrv_query( $conn, $sql);
      
            
            
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "message: ".$error[ 'message']."<br />";
                
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {
                echo  $sql;
                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";
            }
            print "</div>";
        }
    }
  
	function iilinea(){
        include ("conexionSQL.php");   
        global $fichero_subidoSQL;
        global $link;
        $conn=sqlsrv_connect($server,$connectionInfo);
        if( $conn === false) {
            die( print_r( sqlsrv_errors(), true));
            $errors = sqlsrv_errors();
        }
  
        $sql = "truncate table instalacionLinea";
         $stmt = sqlsrv_query( $conn, $sql);
        if( !$stmt ) {
            echo "<p>Error Borrando base anterior instalacionLinea. Escriba al área de Automatización - Bogotá</p>";
            die( print_r( sqlsrv_errors(), true));
        }else{
             
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
            $sql="BULK INSERT instalacionLineaTemporal FROM '$fichero_subidoSQL' 
            WITH
            (
                FIRSTROW = 2,
                FIELDTERMINATOR = ';',
                ROWTERMINATOR = '\\n',
                CODEPAGE=65001
            
            )";
                     
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
           
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
            }
         
            $sql="Insert INTO [dbo].[instalacionLinea] ([producto] ,[procedimiento] )                    
                        SELECT [producto] ,[procedimiento] 
                        FROM  [instalacionLineaTemporal]";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
                       
            if( $conn === false) {
                die( print_r( sqlsrv_errors(), true));
                $errors = sqlsrv_errors();
            }
            $sql = "truncate table instalacionLineaTemporal";
            $stmt = sqlsrv_query( $conn, $sql);
            sqlsrv_free_stmt( $stmt);
            
            if( !$stmt ) {
                die( print_r( sqlsrv_errors(), true));
                echo "<h2>Error subiendo a base de datos.</h2>";
                echo "<h3>Detalles:</h3>";
                echo "message: ".$error[ 'message']."<br />";
                echo "<h4>Cómo solucionarlo</h4>";
                echo "<h5>Solución 1:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. Guarde el archivo e intente de nuevo.</p>";
                echo "<h5>Solución 2:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8. Guarde el archivo e intente de nuevo</p>";
                echo "<h5>Solución 3:</h5>";
                echo "<p class='mensaje' style='white-space: normal;'>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@comdatagroup.com</b></p>";
            } else {

                echo "<p class='mensaje'>Proceso Completado con Éxito</p>";

            }

            print "</div>";

        }

    }
?>
