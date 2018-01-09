<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["Usuario"]) ){
        header("Location: login.php");
        exit;
    }
    if(isset($_SESSION["Nueva"]) ){
        unset($_SESSION["Nueva"]);
        header("Location: cerrarSesion.php");
        exit;
    }
?>
<html>
    <head>
        <title>Samsung - Reportes</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css"> 
        <link rel="stylesheet" type="text/css" href="../css/subir.css"> 
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <img style="height:150px;" src="../img/samsung.png" alt="Logo samsung">
        </header>

        <?php 
            include("conexion.php");
            header('Content-Type: text/html; charset=UTF-8'); 
            
            if (!($link=mysqli_connect($server,$user,$pass,$db)))  
            {  
                echo "Error conectando a la base de datos.";  
                exit();  
            }  
            mysqli_set_charset($link, "utf8");
            ?>
        <div style="text-align: center; margin: 10px;" id="botones">
            <h2>Seleccione el archivo a subir</h2>
            <button class="Boton" onclick="seleccion('ASC')">ASC</button>
            <button class="Boton" onclick="seleccion('TIPIFICACION')">TIPIFICACIÓN</button>
            <button class="Boton" onclick="seleccion('PRODUCTOS')">PRODUCTOS</button>
        </div>

        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input name="opcion" id="opcion" style="display:none"></input>
            <div>
                <input type="file" id="data" name="data" accept=".csv">
            </div>
            <div id="fechas" style="display:none">
                <!-- <label> -->
                    <b>Activo desde:</b>
                <!-- </label> -->
                <input class="fechaHora" type="date" name="fecha" id="fecha"></input>
                <span><b> a la(s) </b></span>
                <input class="fechaHora" type="time" name="hora" id="hora"></input>
            </div>
            <div class="preview">
                <p id="Archivo">No ha seleccionado ningún archivo. Fecha y hora no pueden ir vacios</p>
            </div>
            <div>
                <button class="otroBoton">Subir</button>
                <button class="otroBoton">Activar ahora</button>
            </div>
        </form>

        <div id="descripcion">
            <h3 style="margin-left: 20px; display:none" id="titulo">Descripción del archivo</h3>
            <div id="texto_descripcion">
            </div>
        </div>

        <?php
            if( isset($_FILES['data']['name']) && $_FILES['data']['name'] != "" ) {
                $dir_subida = 'C:/wamp64/www/samsung/data/asc/';
                // $dir_subida = 'C:\\inetpub\\wwwroot\\samsung\\';
                $nombre = "ASC_".$_POST['fecha']."_".$_POST['hora'].".csv";
                $nombre = str_replace(":","-",$nombre);
                $fichero_subido = $dir_subida.basename($nombre);

                echo '<div id="respuesta" style="display: block" >';
                if (copy($_FILES['data']['tmp_name'], $fichero_subido)) {
                    $result = exec("..\Conversor.exe ../data/asc/".$nombre." ../temp.csv ".$_POST['opcion']);
                    if( $result != "Completado..." ) {
                        echo "<h2>Error en Archivo</h2>";
						echo "<p>".$result."</p>";
                    } else {
                        $tipo = $_POST['opcion'];
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
                global $link;
                $query = "truncate samsung.asc2";
                $result = mysqli_query($link, $query);
                if( $result == 0 ) {
                    echo "<p>Error Borrando base anterior ASC. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
                } else {
                    // $query = "load data local infile 'C:/inetpub/wwwroot/samsung/temp.csv' into table samsung.asc2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`TIPO DE SERVICIO`,`OG`,`ASC`,`Ciudad`,`Departamento`,`TIPO DE ORDEN`,`RELLAMADO`,`Almacen de compra`,`PRIORIDAD`,`RUTA`,`Observacion`,`Regional`,`LED`,`LCD`,`LFD`,`REF`,`WSM`,`DRY`,`SRA`,`DVM`);";
                    $query = "load data local infile 'C:/wamp64/www/samsung/temp.csv' into table samsung.asc2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`TIPO DE SERVICIO`,`OG`,`ASC`,`Ciudad`,`Departamento`,`TIPO DE ORDEN`,`RELLAMADO`,`Almacen de compra`,`PRIORIDAD`,`RUTA`,`Observacion`,`Regional`,`LED`,`LCD`,`LFD`,`REF`,`WSM`,`DRY`,`SRA`,`DVM`);";
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
                global $link;
                $query = "truncate samsung.tipificacion2";
                $result = mysqli_query($link, $query);
                if( $result == 0 ) {
                    echo "<p>Error Borrando base anterior TIPIFICACION. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
                } else {
                    $query = "load data local infile 'C:/wamp64/www/samsung/temp.csv' into table samsung.tipificacion2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`producto`,`sintoma 1`,`sintoma 2`,`sintoma 3`,`sintoma 4`,`Procedimiento`);";
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
                global $link;
                $query = "truncate samsung.dpa_productos2";
                $result = mysqli_query($link, $query);
                if( $result == 0 ) {
                    echo "<p>Error Borrando base anterior PRODUCTOS. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
                } else {
                    $query = "load data local infile 'C:/wamp64/www/samsung/temp.csv' into table samsung.dpa_productos2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`PRODUCTOS`,`TIPO`,`PERTENECE`);";
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
        <div class="alert" id="error" style="display:none">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Error!</strong> No se pudo eliminar el archivo.
        </div>
        <div class="alert ok" id="ok" style="display:none">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Completado!</strong> Archivo eliminado con éxito.
        </div>
    </body>
    <script>
        var input = document.querySelectorAll('input')[1];
        var preview = document.getElementById("Archivo");

        input.addEventListener('change', updateImageDisplay);
        
        function updateImageDisplay() {
            var curFiles = input.files;
            if(curFiles.length != 0) {
                preview.textContent = curFiles[0].name + ', Tamaño ' + returnFileSize(curFiles[0].size) + '.';                
            }
        }

        function returnFileSize(number) {
            if(number < 1024) {
                return number + ' bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + ' KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + ' MB';
            }
        }

        function seleccion( opcion ) {
            if( opcion == "ASC" ) {
                document.getElementById("fechas").style.display = "block";
            } else {
                document.getElementById("fechas").style.display = "none";
            }

            if( document.getElementById("respuesta") ){
                document.getElementById("respuesta").style.display = "none";
            }
            var num;
            var titulo = document.getElementById("titulo");
            var texto = document.getElementById("texto_descripcion");
            var inputOpcion = document.getElementById("opcion");
            num = ( opcion == "ASC" ) ? 0 : ( ( opcion == "TIPIFICACION" ) ? 1 : 2); 
            var boton = document.getElementsByTagName("button");
            if( boton[num].className == "Boton active" ) {
                boton[num].className = "Boton";
            } else {
                boton[0].className = "Boton";
                boton[1].className = "Boton";
                boton[2].className = "Boton";
                boton[num].className += " active";
                titulo.innerHTML = "Encabezado de " + opcion ;
                titulo.style.display = "block";

                texto.style.display = "block";  
                if( opcion == "ASC" ) {
                    texto.innerHTML = "<p class='mensaje'>TIPO DE SERVICIO;OG;ASC;Ciudad;Departamento;TIPO DE ORDEN;RELLAMADO;Almacen de compra;PRIORIDAD;RUTA;Observacion;Regional;LED;LCD;LFD;REF;WSM;DRY;SRA;DVM</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });
                    
                    inputOpcion.value = "ASC";
                } else if( opcion == "TIPIFICACION" ) {
                    texto.innerHTML = "<p class='mensaje'>producto;sintoma 1;sintoma 2;sintoma 3;sintoma 4;Procedimiento</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });

                    inputOpcion.value = "TIPIFICACION";
                } else if( opcion == "PRODUCTOS" ) {
                    texto.innerHTML = "<p class='mensaje'>PRODUCTOS;TIPO;PERTENECE</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });

                    inputOpcion.value = "PRODUCTOS";
                }
            }
        }

        function accionArchivo( archivo ) {
            alert( archivo );
        }

        function eliminarArchivo( archivo ) {
            $.ajax({
                type: 'post',
                url: 'eliminarArchivo.php', 
                data: {
                    file:archivo
                },
                success: function (response) {
                    if( response == "error" ) {
                        document.getElementById("error").style.display = "block";
                        setTimeout(() => {
                            document.getElementById("error").style.display = "none";
                        }, 5000);
                    } else {
                        document.getElementById("ok").style.display = "block";
                        setTimeout(() => {
                            document.getElementById("ok").style.display = "none";
                        }, 5000);
                        var opcion = document.getElementById("opcion").value;
                        seleccion(opcion);
                        seleccion(opcion);
                    }
                }
            });
        }
    </script>
</html>