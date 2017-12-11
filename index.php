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
        <link rel="stylesheet" type="text/css" href="css/style.css"> 
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <img style="height:150px;" src="img/samsung.png" alt="Logo samsung">
        </header>

        <?php 
            include("php/Lista.php");
            include("php/conexion.php");
            header('Content-Type: text/html; charset=UTF-8'); 
            
            if (!($link=mysqli_connect($server,$user,$pass,$db)))  
            {  
                echo "Error conectando a la base de datos.";  
                exit();  
            }  
            mysqli_set_charset($link, "utf8");
            ?>

    <div id="opciones">
        <div class="Bloque">
            <label for="Departamento">Departamento</label>
            <!-- <select name="Departamento[]" id="Departamento" onchange="jDepartamento(this.value)" multiple> -->
            <select name="Departamento[]" id="Departamento" multiple>
                <?php
                    $result = mysqli_query($link, "SELECT c.estado FROM cliente c, transaccion t WHERE c.numeroidentificacion = t.numeroidentificacion_cliente;");
                    
                    $lista = array();
                    while($row = mysqli_fetch_row($result))
                    {
                        $lista[] = $row[0];
                    }
                    $lista = array_unique( $lista );
                    sort( $lista );
                    array_unshift( $lista, "" );
                    foreach( $lista as $valor ) {
                        echo '<option value = "'.$valor.'">'.$valor.'</option>';
                    }
                    ?>
            </select>
        </div>

        <div class="Bloque">
            <label for="Ciudad">Ciudad</label>
            <!-- <select name="Ciudad" id="Ciudad" onchange='jCiudad(this.value)'> -->
                <!-- <select name="Ciudad" id="Ciudad" multiple>
                    </select> -->
            <select name="Ciudad" id="Ciudad" multiple>
                <?php
                    $result = mysqli_query($link, "SELECT c.distrito2 FROM cliente c, transaccion t WHERE c.numeroidentificacion = t.numeroidentificacion_cliente;");
                    
                    $lista = array();
                    while($row = mysqli_fetch_row($result))
                    {
                        $lista[] = $row[0];
                    }
                    $lista = array_unique( $lista );
                    sort( $lista );
                    array_unshift( $lista, "" );
                    foreach( $lista as $valor ) {
                        echo '<option value = "'.$valor.'">'.$valor.'</option>';
                    }
                    ?>
            </select>
        </div>    
                
        <div class="Bloque">
                <label for="Tipo1">Tipología 1</label>
                <!-- <select name="Tipo1" id="Tipo1" onchange="jTipo1(this.value)"> -->
                    <select name="Tipo1" id="Tipo1" multiple>
                        <?php
                    $result = mysqli_query($link, "SELECT t.sintoma_cat1 FROM transaccion t;");
                    
                    $lista = array();
                    while($row = mysqli_fetch_row($result))
                    {
                        $lista[] = $row[0];
                    }
                    $lista = array_unique( $lista );
                    sort( $lista );
                    array_unshift( $lista, "*Sin datos" );
                    array_unshift( $lista, "" );
                    foreach( $lista as $valor ) {
                        echo '<option value = "'.$valor.'">'.$valor.'</option>';
                    }
                    ?>
            </select>
        </div>
        
        <div class="Bloque">
            <label for="Tipo3">Tipología 3</label>
            <!-- <select name="Tipo3" id="Tipo3" onchange="jTipo3(this.value)"> -->
                <select name="Tipo3" id="Tipo3" multiple>
                    <?php
                    $result = mysqli_query($link, "SELECT t.sintoma_cat3 FROM transaccion t;");
                    
                    $lista = array();
                    while($row = mysqli_fetch_row($result))
                    {
                        $lista[] = $row[0];
                    }
                    $lista = array_unique( $lista );
                    sort( $lista );
                    array_unshift( $lista, "*Sin datos" );
                    array_unshift( $lista, "" );
                    foreach( $lista as $valor ) {
                        echo '<option value = "'.$valor.'">'.$valor.'</option>';
                    }
                    ?>
            </select>
        </div>
        
        <div class="Bloque">
            <label for="Almacen">Almacén</label>
            <!-- <select name="Tipo2" id="Tipo2" onchange="jTipo2(this.value)"> -->
                <select name="Almacen" id="Almacen" multiple>
                    <?php
                    $result = mysqli_query($link, "SELECT t.almacen FROM transaccion t;");
                    
                    $lista = array();
                    while($row = mysqli_fetch_row($result))
                    {
                        $lista[] = $row[0];
                    }
                    $lista = array_unique( $lista );
                    sort( $lista );
                    array_unshift( $lista, "*Sin datos" );
                    array_unshift( $lista, "" );
                    foreach( $lista as $valor ) {
                        echo '<option value = "'.$valor.'">'.$valor.'</option>';
                    }
                    ?>
            </select>
        </div>
        
        <div class="Bloque">
            <label for="Estado">Estado</label>
            <!-- <select name="Estado" id="Estado" onchange="jEstado(this.value)"> -->
                <select name="Estado" id="Estado" multiple>
                    <?php
                    $result = mysqli_query($link, "SELECT t.estado FROM transaccion t;");
                    
                    $lista = array();
                    while($row = mysqli_fetch_row($result))
                    {
                        $lista[] = $row[0];
                    }
                    $lista = array_unique( $lista );
                    sort( $lista );
                    array_unshift( $lista, "*Sin datos" );
                    array_unshift( $lista, "" );
                    foreach( $lista as $valor ) {
                        echo '<option value = "'.$valor.'">'.$valor.'</option>';
                    }
                    ?>
            </select>
        </div>
        
        <!-- <br> -->
        <div class="Bloque">
            <label for="Agente">Agente</label>
            <!-- <input type="text" name="Agente" id="Agente" onchange="jAgente(this.value)"> -->
            <input type="text" name="Agente" id="Agente" placeholder="Agente" onkeypress="pulsar(event)">
        <!-- </div>

        <div class="Bloque"> -->
            <label for="Cedula">Cédula cliente</label>
            <!-- <input type="text" name="Agente" id="Agente" onchange="jAgente(this.value)"> -->
            <input type="text" name="Cedula" id="Cedula" placeholder="Cédula" onkeypress="pulsar(event)">
            <label for="fecha1">Fecha inicial</label>
            <input type="date" name="fecha1" id="fecha1">
            <label for="fecha2">Fecha final</label>
            <input type="date" name="fecha2" id="fecha2">
        </div>

        <div class="Bloque">
            <div>
                <input type="radio" class="linea" id="II"
                name="contact" value="II">
                <label class="labelLinea" for="II">II</label>
            </div>
            <div>
                <input type="radio" class="linea" id="IH"
                name="contact" value="IH">
                <label class="labelLinea" for="IH">IH</label>
            </div>
            <div>
                <input type="radio" class="linea" id="DTV"
                name="contact" value="DTV">
                <label class="labelLinea" for="DTV">DTV</label>
            </div>
        </div>
            
            <br>
            <button id="btnBuscar" class="otroBoton" onclick="buscar()">Buscar</button>
            <button id="btnExport" class="otroBoton">Exportar a Excel</button>
            <button class="otroBoton" onclick="recargar()">Nueva búsqueda</button>
            <button class="otroBoton" onclick="window.location.href='php/subir.php'">Subir archivo</button>

            <button class="otroBoton" id="cerrar" onclick="location.href='cerrarSesion.php'">Cerrar sesión</button>
        </div>
        
        <div id="table_wrapper">
            <table id="Table">
                <thead>
                    <tr>  
                        <th>Fecha</th> 
                        <th>Hora</th> 
                        <th>ASC</th> 
                        <th>Tipo</th> 
                        <th>Orden</th> 
                        <th>Modelo</th>  
                        <th>Tipo de producto</th>  
                        <th>Tipología 1</th>  
                        <th>Tipología 2</th>  
                        <th>Tipología 3</th>  
                        <th>Resolución</th>  
                        <th>Estado</th>  
                        <th>Razón</th>  
                        <th>Almacén</th>  
                        <th>Agente</th>  
                        <th>Cliente</th>  
                        <th>Cédula</th>  
                        <th>Teléfono</th>  
                        <th>Ciudad</th>  
                        <th>Departamento</th>  
                    </tr>  
                </thead>
                <tbody id="Tabla">
                   
                </tbody>
            </table>
        </div>            
    </body>
    <script src="js/reload.js"></script>
</html>