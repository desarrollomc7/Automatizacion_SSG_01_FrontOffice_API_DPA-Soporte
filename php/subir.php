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

        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div>
                <input type="file" id="data" name="data" accept=".csv">
            </div>
            <div class="preview">
                <p>No ha seleccionado ningún archivo</p>
            </div>
            <div>
                <button class="otroBoton">Subir</button>
            </div>
        </form>
        <?php
            if( isset($_FILES['data']['name']) ) {
                $dir_subida = 'C:/wamp64/www/samsung/';
                // $dir_subida = 'C:/inetpub/wwwroot/samsung/';
                $fichero_subido = $dir_subida.basename("TIPIFICACION.csv");

                echo '<div class="respuesta">';
                if (move_uploaded_file($_FILES['data']['tmp_name'], $fichero_subido)) {
                    $result = exec('..\Conversor.exe ..\TIPIFICACION.csv ..\temp.csv');
                    if( $result != "Completado..." ) {
                        echo "<p>Error convirtiendo archivo a UTF8</p>";
                    }

                    $query = "truncate asc2";
                    $result = mysqli_query($link, $query);
                    if( $result == 0 ) {
                        echo "<p>Error Borrando base anterior. Escriba a diegofernando.rodriguez@grupodigitex.com</p>";
                    }
                    
                    $query = "load data local infile 'C:/wamp64/www/samsung/temp.csv' into table asc2 CHARACTER set UTF8 fields terminated by ';' lines terminated by '\r\n' IGNORE 1 lines (`TIPO DE SERVICIO`,`OG`,`ASC`,`Ciudad`,`Departamento`,`TIPO DE ORDEN`,`RELLAMADO`,`Almacen de compra`,`PRIORIDAD`,`RUTA`,`Observacion`,`Regional`,`LED`,`LCD`,`LFD`,`REF`,`WSM`,`DRY`,`SRA`,`DVM`);";
                    $result = mysqli_query($link, $query);
                    if( $result == 0 ) {
                        echo "<p>Formato incorrecto de CSV.</p>";
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
                } else {
                    echo "<p>Fichero no valido</p>";
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
        
        div > p {
            background: #eee;
            border: 1px solid black;
        }

        form p, .respuesta > p {
            line-height: 32px;
            padding-left: 10px;
        }
        .respuesta {
            margin: 20px auto;
            width: 500px;
        }
    </style>
    <script>
        var input = document.querySelector('input');
        var preview = document.querySelector('.preview');

        input.addEventListener('change', updateImageDisplay);
        
        function updateImageDisplay() {
            var curFiles = input.files;
            if(curFiles.length != 0) {
                preview.children[0].textContent = curFiles[0].name + ', Tamaño ' + returnFileSize(curFiles[0].size) + '.';                
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
    </script>
</html>