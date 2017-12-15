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
            <button class="Boton" onclick="seleccion('DPA PRODUCTOS')">DPA PRODUCTOS</button>
        </div>

        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <!-- <input name="opcion" id="opcion" style="display:none"></input> -->
            <input name="opcion" id="opcion" ></input>
            <div>
                <input type="file" id="data" name="data" accept=".csv">
            </div>
            <div class="preview">
                <p id="Archivo">No ha seleccionado ningún archivo</p>
            </div>
            <div>
                <button class="otroBoton">Subir</button>
            </div>
        </form>

        <div id="descripcion">
            <h3 style="margin-left: 20px; display:none" id="titulo">Descripción del archivo</h3>
            <div id="texto_descripcion">
            </div>
        </div>

        <?php
            echo $_POST['opcion'];
            if( isset($_FILES['data']['name']) && $_FILES['data']['name'] != "" ) {
                $dir_subida = 'C:/wamp64/www/samsung/';
                // $dir_subida = 'C:\\inetpub\\wwwroot\\samsung\\';
                $fichero_subido = $dir_subida.basename("TIPIFICACION.csv");

                echo '<div class="respuesta">';
                if (copy($_FILES['data']['tmp_name'], $fichero_subido)) {
                    $result = exec("..\Conversor.exe ../TIPIFICACION.csv ../temp.csv");
                    if( $result != "Completado..." ) {
                        echo "<p>Error convirtiendo archivo a UTF8</p>";
						echo "<p>".$result."</p>";
                    } else {
						// $query = "truncate samsung.asc";
						// $result = mysqli_query($link, $query);
						if( $result == 0 ) {
							echo "<p>Error Borrando base anterior. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
						} else {
							$query = "load data local infile 'C:\\inetpub\\wwwroot\\samsung\\temp.csv' into table samsung.asc CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`TIPO DE SERVICIO`,`OG`,`ASC`,`Ciudad`,`Departamento`,`TIPO DE ORDEN`,`RELLAMADO`,`Almacen de compra`,`PRIORIDAD`,`RUTA`,`Observacion`,`Regional`,`LED`,`LCD`,`LFD`,`REF`,`WSM`,`DRY`,`SRA`,`DVM`);";
							$result = mysqli_query($link, $query);
							if( $result == 0 ) {
								echo "<p>Error subiendo CSV.</p>";
								echo "<h3>Detalles:</h3>";
								echo "<p>".mysqli_error($link)."</p>";
								echo "<h4>Cómo solucionarlo</h4>";
								echo "<h5>Solución 1:</h5>";
								echo "<p>Cuando aparezca el mensaje <b>Invalid utf8 character string</b> abra el archivo CSV en algún editor de texto y busque la palabra que aparece despues del dos puntos (:) y verifique que no contenga simbolos especiales. guarde el archivo e intente de nuevo.</p>";
								echo "<h5>Solución 2:</h5>";
								echo "<p>Abra el archivo CSV en el bloc de notas, luego 'Guardar Como', luego en el campo 'Codificación' elija <b>UTF-8</b>. Guarde el archivo e intente de nuevo</p>";
								echo "<h5>Solución 3:</h5>";
								echo "<p>Si sigue sin solucionar el problema escriba a: <b>diegofernando.rodriguez@grupodigitex.com</b></p>";
							} else {
								echo "<p>Proceso Completado con Éxito</p>";
							}
							print "</div>";
						}
					}                    
                } else {
                    echo "<p>No se pudo subir el archivo</p>";
                }
            }
        ?>
    </body>

    <style>
        input {
            margin: 0px;
        }
        form {
            width: 600px;
            background: #aaa;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid black;
        }
        
        #Archivo {
            background: #eee;
            border: 1px solid black;
        }

        form p, .respuesta > p {
            line-height: 32px;
            padding-left: 10px;
        }
        .respuesta {
            margin: 20px auto;
            width: 95%;
        }
        .Boton{
            background-color: #DDD;
            color: #black;
            padding: 10px 32px;
            margin: 0 5px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            border: 0px;
            outline: none;
            cursor: pointer;
        }

        .active {
            background-color: #0F21ff;
            color: white;
            cursor: pointer;
        }

        #texto_descripcion {
            margin: 20px auto;
            width: 95%;
        }
    </style>
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
                    texto.innerHTML = "<p>TIPO DE SERVICIO;OG;ASC;Ciudad;Departamento;TIPO DE ORDEN;RELLAMADO;Almacen de compra;PRIORIDAD;RUTA;Observacion;Regional;LED;LCD;LFD;REF;WSM;DRY;SRA;DVM</p>";
                    inputOpcion.value = "ASC";
                } else if( opcion == "TIPIFICACION" ) {
                    texto.innerHTML = "<p>producto;sintoma 1;sintoma 2;sintoma 3;sintoma 4;Procedimiento</p>";
                    inputOpcion.value = "TIPIFICACION";
                } else if( opcion == "DPA PRODUCTOS" ) {
                    texto.innerHTML = "<p>PRODUCTOS;TIPO;PERTENECE</p>";
                    inputOpcion.value = "PRODUCTOS";
                }
            }
        }
    </script>
</html>