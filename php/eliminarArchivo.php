<?php
    if( unlink($_POST['file']) ) {
        echo "ok";
    } else {
        echo "error";
    }
?>