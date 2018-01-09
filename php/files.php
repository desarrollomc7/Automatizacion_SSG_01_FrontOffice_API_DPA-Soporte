<?php
    echo "<h3>Historial</h3>";

    function listarArchivos( $path ) {
        if( file_exists( $path ) && is_dir( $path ) ) {
            echo "<br>";
            $result = scandir( $path );
            $files = array_diff( $result, array(".","..") );

            if( count($files) > 0 ) {
                foreach( $files as $file ) {
                    if( is_file("$path/$file") ) {
                        $file = str_replace("ASC_","",$file);
                        $file = str_replace("_"," ",$file);
                        $file = str_replace(".csv","",$file);
                        $file[13] = ":";
                        echo "<div id='opcion'>
                                <img src='../img/icon-csv.png' alt='icono csv'>
                                <p>$file</p>
                                <img class='arrow' src='../img/up.png' alt='Subir' title='Subir CSV'>
                                <img class='arrow' src='../img/down.png' alt='Descargar csv' title='Descargar CSV'>
                                <img class='arrow' src='../img/x.png' alt='Eliminar' title='Eliminar CSV'>
                            </div>";
                    }
                }
            } else {
                echo "<h3>ERROR: No hay archivos a listar</h3>";
            }
        } else {
            echo "<h3>ERROR: No existe el directorio</h3>";
        }
    }

    listarArchivos( "C:/wamp64/www/samsung/data/".$_POST['opc'] );
    // listarArchivos( "C:/wamp64/www/samsung/data/tipificacion" );
    // listarArchivos( "C:/wamp64/www/samsung/data/productos" );
?>