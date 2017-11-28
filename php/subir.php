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
                    echo "<p>El fichero es válido y se subió con éxito.</p>";
                } else {
                    echo "<p>Fichero no valido</p>";
                }
                print "</div>";
                exec('..\Conversor.exe ..\TIPIFICACION.csv');
                
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