// console.log("Cargando reload.js");
//No funciona por el momento
// $(document).ready(function(){
//     $('#table_wrapper').doubleScroll();
//     alert("activado");
// });

//Actualizar tabla con datos del formulario
function jDepartamento(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarDepartamento.php',
        data: {
            // departamento:val
            departamento:$('#Departamento').val()
        },
        success: function (response) {
            document.getElementById("Ciudad").innerHTML=response; 
        }
    });
    // $.ajax({
        //     type: 'post',
        //     url: 'php/actualizarTabla.php',
        //     data: {
            //         departamento:val,
            //         tipo1:$('#Tipo1').val(),
            //         tipo2:$('#Tipo2').val(),
            //         tipo3:$('#Tipo3').val()
            //     },
            //     success: function (response) {
                //         document.getElementById("Tabla").innerHTML=response; 
                //     }
                // });
}
            
function jCiudad(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            ciudad:val,
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val(),
            departamento:$('#Departamento').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

function jAgente(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            agente:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}
function jTipo1(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            tipo1:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}
function jTipo2(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            tipo2:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}
function jTipo3(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            tipo3:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

function jEstado(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            estado:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

//Completo con boton Buscar
var myVar;
function buscar()
{
    clearTimeout(myVar);
    document.getElementById("bloqueo").style.display = "flex";
    var startTime = new Date();
    // debugger;
    if( $('#fecha1').val() == "" && $('#fecha2').val() == "") {
        var d = new Date();
        var mes = d.getMonth() + 1;
        var dia = ( d.getDate() < 10 ) ? "0" + d.getDate() : d.getDate();
        var n = d.getFullYear() + "-" + mes + "-" + dia;
        document.getElementById("fecha1").value = n;
    }
    document.getElementById("Tabla").click();
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            estado:$('#Estado').val(),
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            agente:$('#Agente').val(),
            cedula:$('#Cedula').val(),
            tipo1:$('#Tipo1').val(),
            tipo3:$('#Tipo3').val(),
            almacen:$('#Almacen').val(),
            fecha1:$('#fecha1').val(),
            fecha2:$('#fecha2').val(),
            linea:$('input[name=linea]:checked').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
            document.getElementById("bloqueo").style.display = "none";
        }
    });
    myVar = setTimeout(buscar,120000);
}

function jNombre(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            nombre:val,
            cedula:$('#Usuario').val(),
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

//Exportar directamente de ajax a CSV
function exportar()
{
    var cabeceras = document.getElementsByTagName("TH");
    var tablaExportar = "Datos";
    for( i = 0; i < cabeceras.length; i++ ) {
		if( cabeceras[i].innerHTML == "Tiempo Total" ) {
            tablaExportar = "Tiempo"
        }
		if( cabeceras[i].innerHTML == "Mensaje" ) {
            tablaExportar = "SMS"
        }
		if( cabeceras[i].innerHTML == "IP" ) {
            tablaExportar = "IP"
        }
    }

    if( tablaExportar == "Datos" ) {
        clearTimeout(myVar);
        document.getElementById("bloqueo").style.display = "flex";
        var startTime = new Date();
        // debugger;
        document.getElementById("Tabla").click();
        $.ajax({
            type: 'post',
            url: 'php/exportarDatos.php',
            data: {
                estado:$('#Estado').val(),
                ciudad:$('#Ciudad').val(),
                departamento:$('#Departamento').val(),
                agente:$('#Agente').val(),
                cedula:$('#Cedula').val(),
                tipo1:$('#Tipo1').val(),
                tipo3:$('#Tipo3').val(),
                almacen:$('#Almacen').val(),
                fecha1:$('#fecha1').val(),
                fecha2:$('#fecha2').val(),
                linea:$('input[name=linea]:checked').val()
            },
            success: function (response) {
                // document.getElementById("Tabla").innerHTML=response; 
                
                var endTime = new Date();
                var timeDiff = endTime - startTime;
                timeDiff /= 1000;
                
                var a = document.createElement('a');
                a.href = "php/temp.csv";
                var fecha = new Date();
                a.download = "NReporte_" + new String(fecha.getDate()) + "-" + new String(fecha.getMonth()) + "-" + new String(fecha.getFullYear()) + "/" + new String(fecha.getHours()) + "." + new String(fecha.getMinutes()) + ".csv";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // document.getElementById("Tabla").innerHTML = '<h4>Completado en ' + timeDiff + ' seg</h4>';
                document.getElementById("bloqueo").style.display = "none";
                // buscar();
            }
        });
    } 
    else if( tablaExportar == "Tiempo" ){
        clearTimeout(myVar);
        document.getElementById("bloqueo").style.display = "flex";
        $.ajax({
            type: 'post',
            url: 'php/exportarTiempos.php',
            data: {
                fecha1:$('#fecha1').val(),
                fecha2:$('#fecha2').val(),
                agente:$("#Agente").val(),
                cedula:$("#Cedula").val()
            },
            success: function (response) {
                // document.getElementById("Tabla").innerHTML=response; 
                var endTime = new Date();
                var timeDiff = endTime - startTime;
                timeDiff /= 1000;
                
                var a = document.createElement('a');
                a.href = "php/temp.csv";
                var fecha = new Date();
                a.download = "NTiempos_" + new String(fecha.getDate()) + "-" + new String(fecha.getMonth()) + "-" + new String(fecha.getFullYear()) + "/" + new String(fecha.getHours()) + "." + new String(fecha.getMinutes()) + ".csv";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                document.getElementById("bloqueo").style.display = "none";
            }
        });
    }
	else if( tablaExportar == "IP" ){
        clearTimeout(myVar);
        document.getElementById("bloqueo").style.display = "flex";
        $.ajax({
            type: 'post',
            url: 'php/exportarIP.php',
            data: {
                agente:$("#Agente").val()
            },
            success: function (response) {
                // document.getElementById("Tabla").innerHTML=response; 
                var endTime = new Date();
                var timeDiff = endTime - startTime;
                timeDiff /= 1000;
                
                var a = document.createElement('a');
                a.href = "php/temp.csv";
                var fecha = new Date();
                a.download = "NAgentes_" + new String(fecha.getDate()) + "-" + new String(fecha.getMonth()) + "-" + new String(fecha.getFullYear()) + "/" + new String(fecha.getHours()) + "." + new String(fecha.getMinutes()) + ".csv";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                document.getElementById("bloqueo").style.display = "none";
            }
        });
    }
    else if( tablaExportar == "SMS" ){
        clearTimeout(myVar);
        document.getElementById("bloqueo").style.display = "flex";
        $.ajax({
            type: 'post',
            url: 'php/exportarSMS.php',
            data: {
                fecha1:$('#fecha1').val(),
                fecha2:$('#fecha2').val(),
                agente:$("#Agente").val()
            },
            success: function (response) {
                var a = document.createElement('a');
                a.href = "php/temp.csv";
                var fecha = new Date();
                a.download = "NSMS_" + new String(fecha.getDate()) + "-" + new String(fecha.getMonth()) + "-" + new String(fecha.getFullYear()) + "/" + new String(fecha.getHours()) + "." + new String(fecha.getMinutes()) + ".csv";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                document.getElementById("bloqueo").style.display = "none";
            }
        });
    }
}

//Exportar tabla a excel
$(document).ready(function() {
    $("#btnExport").click(function(e) {
        e.preventDefault();
        var table_div = document.getElementById('table_wrapper');
        var data = table_div.innerHTML.trim().replace(/<\/td><\/tr>/gi,"%0A").replace(/<tr>/gi,"").replace(/<td>/gi,"").replace(/<\/td>/gi,";").replace(/<i>|<\/i>/gi,"").replace(/<thead>|<\/thead>|<tbody>|<\/tbody>|<table>|<\/table>/gi,"").replace(/<\/th><\/tr>/gi,"%0A").replace(/<\/th>/gi,";").replace(/<th>/gi,"").replace('<table id="Tabla">',"").replace(/ /gi,"%20").replace(/&nbsp;/gi,"%20").replace(/&amp;/gi,"&");

        var a = document.createElement('a');
        a.href = "data:text/csv;charset=utf-8,%EF%BB%BF" + data;
        var fecha = new Date();
        a.download = "NReporte_" + new String(fecha.getDate()) + "-" + new String(fecha.getMonth()) + "-" + new String(fecha.getFullYear()) + "/" + new String(fecha.getHours()) + "." + new String(fecha.getMinutes()) + ".csv";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
});

function pulsar(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13) buscar();
}

//reiniciar busqueda 
function recargar(){
    $("#Agente").val("");
    $("#Cedula").val("");
    $("#Nombre").val("");
    $("#Ciudad").val("");
    $("#Departamento").val("");
    $("#Tipo1").val("");
    $("#Tipo3").val("");
    $("#Almacen").val("");
    location.reload();
}


//Prueba de mensajes de carga de UIPath
function test() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.body.innerHTML = '<div style="font-family: sans-serif; position: fixed; background: red; color: white; width: 300px; height: 100px; text-align: center; top: 80%; left: 80%;" id="DCargando"><p style="line-height: 100px;">Cargando DPA. Por favor espere...</p></div>' + document.body.innerHTML;
        }
    };
    xhttp.open("GET", "js/captura.png", true);
    xhttp.send();
}

function tiempos(){
    clearTimeout(myVar);
    document.getElementById("bloqueo").style.display = "flex";
    $.ajax({
        type: 'post',
        url: 'php/actualizarTiempos.php',
        data: {
            fecha1:$('#fecha1').val(),
            fecha2:$('#fecha2').val(),
            agente:$("#Agente").val(),
            cedula:$("#Cedula").val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
            document.getElementById("bloqueo").style.display = "none";
        }
    });
}

function ip(){
    clearTimeout(myVar);
    document.getElementById("bloqueo").style.display = "flex";
    $.ajax({
        type: 'post',
        url: 'php/actualizarIP.php',
        data: {
            agente:$("#Agente").val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
            document.getElementById("bloqueo").style.display = "none";
        }
    });
}

function guardarSms(){
    clearTimeout(myVar);
    document.getElementById("bloqueo").style.display = "flex";
    $.ajax({
        type: 'post',
        url: 'php/actualizarSMS.php',
        data: {
            fecha1:$('#fecha1').val(),
            fecha2:$('#fecha2').val(),
            agente:$("#Agente").val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
            document.getElementById("bloqueo").style.display = "none";
        }
    });
}

