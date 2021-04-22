<?php
    echo "<h3>Historial</h3>";

    function listarArchivos( $path ) {
        if( file_exists( $path ) && is_dir( $path ) ) {
            $result = scandir( $path );
            $files = array_diff( $result, array(".","..") );

            if( count($files) > 0 ) {
                foreach( $files as $file ) {
                    if( is_file("$path/$file") ) {
                        $temp = str_replace("ASC_","",$file);
                        $temp = str_replace("_"," ",$temp);
                        $temp = str_replace(".csv","",$temp);
                        // $temp[13] = ":";
                        echo "<div id='opcion'>
                                <img src='../img/icon-csv.png' alt='icono csv'>
                                <p>$temp</p>
                                <input class='inputfile' type='file' id=$file accept='.csv' onchange=\"subirArchivo('".$_POST['opc']."','$file')\">
                                <label class='labelFlecha' for=$file>
                                    <img class='arrow' src='../img/up.png' alt='Subir' title='Subir CSV'>
                                </label>
                                <a href='../data/".$_POST['opc']."/$file' download>
                                    <img class='arrow' src='../img/down.png' alt='Descargar csv' title='Descargar CSV'>
                                </a>
                                <img class='arrow' src='../img/x.png' alt='Eliminar' title='Eliminar CSV' onclick=\"eliminarArchivo('../data/".$_POST['opc']."/$file')\">
                            </div>";
                    }
                }
            } else {
                echo "<h3>No hay archivos a listar</h3>";
            }
        } else {
            echo "<h3>ERROR: No existe el directorio</h3>";
        }
    }

    listarArchivos( "../data/".$_POST['opc'] );
    // listarArchivos( "C:/wamp64/www/samsung/data/tipificacion" );
    // listarArchivos( "C:/wamp64/www/samsung/data/productos" );
?>