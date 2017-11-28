<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["Usuario"]) or !isset($_SESSION["Nueva"])){
        header("Location: login.php");
        exit;
    }
    if(isset($_SESSION["Usuario"]) and !isset($_SESSION["Nueva"])){
        header("Location: .");
        exit;
    }
?>
<html>
<head>
        <title>Samsung - Nueva Contraseña</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/sesion.css"> 
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <script>
        function error(){
            document.getElementById("mensaje").innerHTML="<p class='error'>¡No coinciden!</p>";
        } 
    </script>
    <div id="cuadro">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Samsung  Reporte </h2>
            <br><br>
            <p>Debe cambiar la contraseña</p>
            <input type="password" id="pass1" placeholder="Nueva Contraseña" name="pass1" autofocus required>
        
            <input type="password" id="pass2" placeholder="Repita la contraseña" name="pass2" required>

            <button type="submit">Iniciar</button>
            <div id="mensaje"></div>
        </form>
    </div>
    <?php
    if(isset($_POST['pass1'])) {   
        include("php/conexion.php");
        // $server = "10.164.62.124";
        // $user = "root";
        // $pass = "qwerty";
        // $db = "samsung";
        // // $server = "localhost";
        // // $user = "root";
        // // $pass = "";
        // // $db = "samsung";
        $usuario = $_SESSION["Usuario"];
        $pass1 = $_POST["pass1"];
        $pass2 = $_POST["pass2"];

        if( $pass1 != $pass2 ) {
            echo "<script>";
            echo "error();";
            echo "</script>";
        } else {        
            if (!($link=mysqli_connect($server,$user,$pass,$db)))  
            {  
                echo "Error conectando a la base de datos.";  
                exit();  
            }  
            mysqli_set_charset($link, "utf8");
            
            $query = "update user set pass = SHA('".$pass1."') where user = '".$usuario."'";
            
            $result = mysqli_query($link, $query);
            
            session_start();
            unset($_SESSION["Nueva"]);
            header('Location: cerrarSesion.php');       
            exit;    
        }
    }
    ?>
</body>
</html>