<?php
    echo "<h1>Cargar archivo</h1>";
    echo $_POST['tipo'];
    echo "<br>";
    echo $_POST['path'];
    echo "<br>";
    echo $_FILES['file']['tmp_name'];

    if( isset($_FILES['file']['name']) && $_FILES['file']['name'] != "" ) {
        $dir_subida = 'C:/wamp64/www/samsung/data/'.$_POST['tipo'].'/';
        // $dir_subida = 'C:\\inetpub\\wwwroot\\samsung\\';
        $nombre = $_POST['path'];
        $fichero_subido = $dir_subida.basename($nombre);
        echo $fichero_subido;

        echo '<div id="respuesta" style="display: block" >';
        if (copy($_FILES['file']['tmp_name'], "../data/temp.csv")) {
            $result = exec("..\Conversor.exe ../data/temp.csv $fichero_subido ".$_POST['tipo']);
            if( $result != "Completado..." ) {
                echo "<h2>Error en Archivo</h2>";
                echo "<p>".$result."</p>";
            } else {
                $tipo = $_POST['tipo'];
                if( $tipo == "ASC" ) {
                    // asc();
                } else
                if( $tipo == "TIPIFICACION" ) {
                    // tipificacion();
                } else
                if( $tipo == "PRODUCTOS" ) {
                    // productos();
                }						
            }                    
        } else {
            echo "<p>No se pudo subir el archivo</p>";
        }
    }
?>
