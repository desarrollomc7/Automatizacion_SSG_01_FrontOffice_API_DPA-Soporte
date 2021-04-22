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
        <script src="js/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <div id="bloqueo" style="width: 100%;height: 100%;z-index: 1000;position: fixed;background-color: black;opacity: .6;color: white;font-size: 500%;text-align: center; display: none;justify-content: center;flex-direction: column;user-select: none;"><div>Cargando...</div></div>
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
                <option value="0">Desactivado para </option>
                <option value="0">mejor rendimiento</option>
            </select>
        </div>

        <div class="Bloque">
            <label for="Ciudad">Ciudad</label>
            <!-- <select name="Ciudad" id="Ciudad" onchange='jCiudad(this.value)'> -->
                <!-- <select name="Ciudad" id="Ciudad" multiple>
                    </select> -->
            <select name="Ciudad" id="Ciudad" multiple>
            <option value="0">Desactivado para </option>
            <option value="0">mejor rendimiento</option>
            </select>
        </div>    
                
        <div class="Bloque">
            <label for="Tipo1">Tipología 1</label>
            <!-- <select name="Tipo1" id="Tipo1" onchange="jTipo1(this.value)"> -->
            <select name="Tipo1" id="Tipo1" multiple>
                    <option value="0">Desactivado para </option>
                    <option value="0">mejor rendimiento</option>
            </select>
        </div>
        
        <div class="Bloque">
            <label for="Tipo3">Tipología 3</label>
            <!-- <select name="Tipo3" id="Tipo3" onchange="jTipo3(this.value)"> -->
            <select name="Tipo3" id="Tipo3" multiple>
                <option value="0">Desactivado para </option>
                <option value="0">mejor rendimiento</option>
            </select>
        </div>
        
        <div class="Bloque">
            <label for="Almacen">Almacén</label>
            <!-- <select name="Tipo2" id="Tipo2" onchange="jTipo2(this.value)"> -->
            <select name="Almacen" id="Almacen" multiple>
                <option value="0">Desactivado para </option>
                <option value="0">mejor rendimiento</option>
            </select>
        </div>
        
        <div class="Bloque">
            <label for="Estado">Estado</label>
            <!-- <select name="Estado" id="Estado" onchange="jEstado(this.value)"> -->
            <select name="Estado" id="Estado" multiple>
                <option value="0">Desactivado para </option>
                <option value="0">mejor rendimiento</option>
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
            <h4>LINEA</h4>
            <div>
                <input type="radio" class="linea" id="II"
                name="linea" value="II" checked>
                <label class="labelLinea" for="II">II</label>
            </div>
            <div>
                <input type="radio" class="linea" id="IH"
                name="linea" value="IH">
                <label class="labelLinea" for="IH">HA</label>
            </div>
            <div>
                <input type="radio" class="linea" id="DTV"
                name="linea" value="DTV">
                <label class="labelLinea" for="DTV">DTV</label>
            </div>
            <div>
                <input type="radio" class="linea" id="HHP"
                name="linea" value="HHP">
                <label class="labelLinea" for="HHP">HHP</label>
            </div>
            <div>
                <input type="radio" class="linea" id="ALL"
                name="linea" value="ALL">
                <label class="labelLinea" for="ALL">TODOS</label>
            </div>
        </div>
            
            <br>
            <button id="btnBuscar" class="otroBoton" onclick="buscar()">Buscar</button>
            <button id="btnExport2" class="otroBoton" onclick="exportar()">Exportar CSV</button>
            <button class="otroBoton" onclick="recargar()">Nueva búsqueda</button>
            <button class="otroBoton" onclick="window.location.href='php/subir.php'">Subir archivo</button>
            <button class="otroBoton" onclick="tiempos()">Tiempo en GCIC</button>
            <button class="otroBoton" onclick="guardarSms()">SMS</button>
			<button class="otroBoton" onclick="ip()">IP</button>

            <button class="otroBoton" id="cerrar" onclick="location.href='cerrarSesion.php'">Cerrar sesión</button>
        </div>
        
        <div id="table_wrapper"><table id="Tabla"></table></div>            
    </body>
    <script src="js/reload.js"></script>
</html>