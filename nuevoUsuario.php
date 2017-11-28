<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["Nueva"]) ){
        unset($_SESSION["Nueva"]);
        header("Location: cerrarSesion.php");
        exit;
    }
    if(isset($_SESSION["Usuario"]) ){
        header("Location: .");
        exit;
    }
?>
<html>
<head>
    <title>Samsung - Nuevo usuario</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/nuevoUsuario.css">
    <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script href="js/jquery-3.2.1.min.js"></script>
    <script>
        function enviando(){
            document.getElementById("solicitar").innerHTML = "Enviando...";
        }
        function enviado(){
            document.getElementById("solicitar").innerHTML = "Solicitud exitosa";
        }
    </script>
</head>
<body>
    <div id="cuadro">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Solicitar Usuario</h2>
            <input type="text" placeholder="Nombres" name="nombres" autofocus required>
            <input type="text" placeholder="Apellidos" name="apellidos" required>
            <input type="email" placeholder="Correo corporativo" name="correo" required>
            <input type="text" placeholder="Usuario de red" name="usuario" required>
            <input type="text" placeholder="Cédula" name="cedula" required>
            <textarea name="mensaje" id="mensaje" cols="30" rows="10" placeholder="Razón de solicitud" required></textarea>
            <button type="submit" id="solicitar">Solicitar</button>
        </form>
    </div>
    <?php
        if(isset($_POST['nombres'])) {   
            $mensaje = "<p> <b>Nombre:</b> ".$_POST['nombres'];
            $mensaje .= " ".$_POST['apellidos']."</p>";
            $mensaje .= "<p> <b>Usuario:</b> ".$_POST['usuario']."</p>";
            $mensaje .= "<p> <b>Correo:</b> ".$_POST['correo']."</p>";
            $mensaje .= "<p> <b>Cedula:</b> ".$_POST['cedula']."</p>";
            $mensaje .= "<p> <b>Razón:</b> ".$_POST['mensaje']."</p>";
            
            // echo $mensaje;
            $para = "diegofernando.rodriguez@grupodigitex.com";
            $titulo = "Solicitud Usuario Samsung";
            
            include "php/class.phpmailer.php";
            include "php/class.smtp.php";
            $email_user = "diegofernando.rodriguez@grupodigitex.com";
            $email_password = "Dfrf4312356";
            $the_subject = "Solicitud Usuario Reporte Samsung - Mensaje Automatico";
            $address_to1 = "diegofernando.rodriguez@grupodigitex.com";
            $address_to2 = "javier.trujillo@grupodigitex.com";
            $from_name = "Solicitud usuario Samsung";
            $phpmailer = new PHPMailer();
            // ---------- datos de la cuenta de Gmail -------------------------------
            $phpmailer->Username = $email_user;
            $phpmailer->Password = $email_password; 
            //-----------------------------------------------------------------------
            // $phpmailer->SMTPDebug = 1;
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->Host = "smtp.gmail.com"; // GMail
            $phpmailer->Port = 465;
            $phpmailer->IsSMTP(); // use SMTP
            $phpmailer->SMTPAuth = true;
            $phpmailer->setFrom($phpmailer->Username,$from_name);
            $phpmailer->AddAddress($address_to1); // recipients email
            $phpmailer->AddAddress($address_to2); // recipients email
            $phpmailer->Subject = $the_subject;	
            $phpmailer->Body .="<h1>Solicitud nuevo usuario</h1>";
            $phpmailer->Body .= $mensaje;
            $phpmailer->Body .= "<br><p>Mensaje automático</p>";
            $phpmailer->IsHTML(true);
            $phpmailer->Send();
            echo "<script>";
            echo "enviado();";
            echo "</script>";
            }
        ?>
</body>
</html>