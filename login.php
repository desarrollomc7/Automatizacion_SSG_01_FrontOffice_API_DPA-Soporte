<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["Nueva"])){
        unset($_SESSION["Nueva"]);
        header("Location: cerrarSesion.php");
        exit;
    }
    if(isset($_SESSION["Usuario"])){
        header("Location: .");
        exit;
    }
?>
<html>
<head>
        <title>Samsung - Iniciar Sesión</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/sesion.css"> 
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <script>
        function error(){
            document.getElementById("mensaje").innerHTML="<p class='error'>¡Usuario inválido!</p>";
        } 
        function nuevaContra(){
            document.getElementById("nuevaContra").innerHTML="<br><br><p>Debe cambiar la contraseña</p><input type='password' id='nueva' placeholder='Nueva Contraseña' name='nueva' required>";
        } 
    </script>
    <div id="cuadro">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Reporte Samsung</h2>
            <input type="text" id="user" placeholder="Usuario" name="user" autofocus required>
        
            <input type="password" id="pass" placeholder="Contraseña" name="pass" required>
            <button type="submit">Iniciar</button>
            <a href="nuevoUsuario.php">¿No tiene usuario?</a> 
            <div id="mensaje"></div>
        </form>
    </div>
    <?php
    if(isset($_POST['user'])) {
        include("php/conexion.php");
        // $server = "10.164.62.124";
        // $user = "root";
        // $pass = "qwerty";
        // $db = "samsung";
        // // $server = "localhost";
        // // $user = "root";
        // // $pass = "";
        // // $db = "samsung";
        $usuario = $_POST["user"];
        $contra = $_POST["pass"];
        
        if (!($link=mysqli_connect($server,$user,$pass,$db)))  
        {  
            echo "Error conectando a la base de datos.";  
            exit();  
        }  
        mysqli_set_charset($link, "utf8");
        
        $query = "select user from user where user = '".$usuario."' and pass = SHA('".$contra."')";

        $result = mysqli_query($link, $query);

        if ( mysqli_num_rows($result) ){
            if( $usuario == $contra ) {
                session_start();
                $_SESSION["Usuario"] = $usuario;
                $_SESSION["Nueva"] = $usuario;
                header("location: nuevaContra.php");
                exit;
            } else {
                session_start();
                $_SESSION["Usuario"] = $usuario;
                header('Location: .');
                exit;
            }
        } else {
            echo "<script>";
            echo "error();";
            echo "</script>";
        }
        
    }
    ?>
</body>
</html>