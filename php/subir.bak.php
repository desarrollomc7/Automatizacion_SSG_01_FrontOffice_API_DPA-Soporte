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
        <link rel="stylesheet" type="text/css" href="../css/subir.css"> 
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="../js/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <header>
            <img style="height:150px;" src="../img/samsung.png" alt="Logo samsung">
        </header>

        <div style="text-align: center; margin: 10px;" id="botones">
            <h2>Seleccione el archivo a subir</h2>
            <button class="Boton" onclick="seleccion('ASC')">ASC</button>
            <button class="Boton" onclick="seleccion('TIPIFICACION')">TIPIFICACIÓN</button>
            <button class="Boton" onclick="seleccion('PRODUCTOS')">PRODUCTOS</button>
            <button class="Boton" onclick="seleccion('PARTES')">PARTES</button>
            <button class="Boton" onclick="seleccion('SMS')">SMS</button>
        </div>

        <div id="form">
            <input name="opcion" id="opcion" style="display:none"></input>
            <div>
                <input type="file" id="data" name="data" accept=".csv">
            </div>
            <div id="fechas" style="display:none">
                <!-- <label> -->
                    <b>Activo desde:</b>
                <!-- </label> -->
                <input class="fechaHora" type="date" name="fecha" id="fecha"></input>
                <span><b> a la(s) </b></span>
                <input class="fechaHora" type="time" name="hora" id="hora"></input>
            </div>
            <div class="preview">
                <p id="Archivo">No ha seleccionado ningún archivo.</p>
            </div>
            <div>
                <button class="otroBoton" id="subir" onclick="subir()">Subir</button>
                <button class="otroBoton" id="verificarBase" onclick="verificar()">Verificar base de datos</button>
            </div>
        </div>

        <div id="descripcion">
            <h3 style="margin-left: 20px; display:none" id="titulo">Descripción del archivo</h3>
            <div id="texto_descripcion">
            </div>
        </div>

        <div class="alert" id="error" style="display:none">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Error!</strong> No se pudo eliminar el archivo.
        </div>
        <div class="alert ok" id="ok" style="display:none">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Completado!</strong> Archivo eliminado con éxito.
        </div>
        <div class="alert ok" id="exito" style="display:none">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Completado!</strong> Archivo cargado!
        </div>
        <div class="alert warning" id="warning" style="display:none">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Atención!</strong> La hora y la fecha no pueden estar vacios.
        </div>
        <div id="mensajes">
        </div>
    </body>
    <script>
        var input = document.querySelectorAll('input')[1];
        var preview = document.getElementById("Archivo");

        input.addEventListener('change', updateImageDisplay);
        
        function mensajeExito() {
            document.getElementById("exito").style.display = "block";
            setTimeout(() => {
                document.getElementById("exito").style.display = "none";
            }, 5000);
        }

        function updateImageDisplay() {
            var curFiles = input.files;
            if(curFiles.length != 0) {
                preview.textContent = curFiles[0].name + ', Tamaño ' + returnFileSize(curFiles[0].size) + '.';                
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

        function seleccion( opcion ) {
            if( opcion == "ASC" ) {
                document.getElementById("fechas").style.display = "block";
                document.getElementById("verificarBase").style.display = "inline";
            } else {
                document.getElementById("fechas").style.display = "none";
                document.getElementById("verificarBase").style.display = "none";
            }

            if( document.getElementById("respuesta") ){
                document.getElementById("respuesta").style.display = "none";
            }
            var num;
            var titulo = document.getElementById("titulo");
            var texto = document.getElementById("texto_descripcion");
            var inputOpcion = document.getElementById("opcion");
            num = ( opcion == "ASC" ) ? 0 : ( ( opcion == "TIPIFICACION" ) ? 1 : ( ( opcion == "PRODUCTOS" ) ? 2 : ( opcion == "PARTES" ) ? 3 : 4)); 
            var boton = document.getElementsByTagName("button");
            if( boton[num].className == "Boton active" ) {
                boton[num].className = "Boton";
            } else {
                boton[0].className = "Boton";
                boton[1].className = "Boton";
                boton[2].className = "Boton";
                boton[3].className = "Boton";
                boton[4].className = "Boton";
                boton[num].className += " active";
                titulo.innerHTML = "Encabezado de " + opcion ;
                titulo.style.display = "block";

                texto.style.display = "block";  
                if( opcion == "ASC" ) {
                    texto.innerHTML = "<p class='mensaje'>TIPO DE SERVICIO;OG;ASC;Ciudad;Departamento;TIPO DE ORDEN;RELLAMADO;Almacen de compra;PRIORIDAD;RUTA;Observacion;Regional;LED;LCD;LFD;REF;WSM;DRY;SRA;DVM</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });
                    
                    inputOpcion.value = "ASC";
                } else if( opcion == "TIPIFICACION" ) {
                    texto.innerHTML = "<p class='mensaje'>linea;producto;sintoma 1;sintoma 2;sintoma 3;sintoma 4 con;sintoma 4 sin;Procedimiento;parte</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });

                    inputOpcion.value = "TIPIFICACION";
                } else if( opcion == "PRODUCTOS" ) {
                    texto.innerHTML = "<p class='mensaje'>PRODUCTOS;TIPO;PERTENECE;BLOQ_SINTOMA</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });

                    inputOpcion.value = "PRODUCTOS";
                } else if( opcion == "PARTES" ) {
                    texto.innerHTML = "<p class='mensaje'>linea;parte</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });

                    inputOpcion.value = "PARTES";
                } else if( opcion == "SMS" ) {
                    texto.innerHTML = "<p class='mensaje'>Landing;Titulo;Linea;Mensaje</p>";

                    $.ajax({
                        type: 'post',
                        url: 'files.php',
                        data: {
                            opc:opcion
                        },
                        success: function (response) {
                            texto.innerHTML += response; 
                        }
                    });

                    inputOpcion.value = "SMS";
                }
            }
        }

        function subirArchivo( tipo ,nombre ) {
            var data = new FormData();
            data.append("tipo", tipo);
            data.append("nombre", nombre);
            data.append("file", document.getElementById(nombre).files[0]);
            data.append("form", "no");
            var request = new XMLHttpRequest();
            request.open("POST","cargarArchivo.php", true);

            request.onreadystatechange = function() {
                if(request.readyState==4 && request.status==200) {
                    document.getElementById("mensajes").innerHTML = request.response;
                    if( request.response.includes("Proceso Completado con Éxito") ) {
                        mensajeExito();
                        seleccion(opcion.value);
                        seleccion(opcion.value);
                    }
                }
            };
            request.send( data );
        }

        function subir(){
            var fecha = document.getElementById("fecha");
            var hora = document.getElementById("hora");
            var opcion = document.getElementById("opcion");
            if( opcion.value == "" ) {
                return;
            }
            if( opcion.value == "ASC") {
                if( hora.value == "" || fecha.value == "" ) {
                    document.getElementById("warning").style.display = "block";
                    setTimeout(() => {
                        document.getElementById("warning").style.display = "none";
                    }, 5000);
                    return;
                }
            } else {
                fecha.value = "";
                hora.value = "";
            }

            if( !document.getElementById("data").files[0] ) {
                return;
            }

            var data = new FormData();
            data.append("file", document.getElementById("data").files[0]);
            data.append("fecha", fecha.value);
            data.append("hora", hora.value);
            data.append("tipo", opcion.value);
            data.append("form", "si");

            var request = new XMLHttpRequest();
            request.open("POST","cargarArchivo.php", true);

            request.onreadystatechange = function() {
                if(request.readyState==4 && request.status==200) {
                    document.getElementById("mensajes").innerHTML = request.response;
                    if( request.response.includes("Proceso Completado con Éxito") ) {
                        mensajeExito();
                        seleccion(opcion.value);
                        seleccion(opcion.value);
                    }
                }
            };
            request.send( data );
        }

        function verificar( ) {
            $.ajax({
                type: 'post',
                url: 'verificar.php', 
                data: {
                    file:""
                },
                success: function (response) {
                    document.getElementById("mensajes").innerHTML = response;
                }
            });
        }

        function eliminarArchivo( archivo ) {
            $.ajax({
                type: 'post',
                url: 'eliminarArchivo.php', 
                data: {
                    file:archivo
                },
                success: function (response) {
                    if( response == "error" ) {
                        document.getElementById("error").style.display = "block";
                        setTimeout(() => {
                            document.getElementById("error").style.display = "none";
                        }, 5000);
                    } else {
                        document.getElementById("ok").style.display = "block";
                        setTimeout(() => {
                            document.getElementById("ok").style.display = "none";
                        }, 5000);
                        var opcion = document.getElementById("opcion").value;
                        seleccion(opcion);
                        seleccion(opcion);
                    }
                }
            });
        }
    </script>
</html>